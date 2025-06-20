<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Event handlers for OAuth2 Direct SSO
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   local_oauthdirectsso
 * @copyright 20/06/2025 LTNC B.V- Moodle gecertificeerd Partner
 * @author    Gemma Lesterhuis
 **/

namespace local_oauthdirectsso;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/user/lib.php');

/**
 * Event handlers for OAuth2 Direct SSO
 *
 * @package   local_oauthdirectsso
 * @copyright 20/06/2025 LTNC B.V- Moodle gecertificeerd Partner
 * @author    Gemma Lesterhuis
 **/
class eventhandlers {

    /**
     * Debug mode flag for development
     *
     * @var bool
     */
    private const DEBUG_MODE = true;

    /**
     * Handle user events (created or updated)
     *
     * @param \core\event\base $event
     * @return bool
     */
    public static function handle_user_event(\core\event\base $event) {
        global $DB, $SESSION;

        $userid = $event->userid;
        if (empty($userid)) {
            return true;
        }

        // Log for debugging purposes
        self::debug_log("Processing user event for user ID: {$userid}, Event: " . get_class($event));

        // Check if the user uses OAuth2 authentication
        $auth = $DB->get_field('user', 'auth', ['id' => $userid]);
        if ($auth !== 'oauth2') {
            self::debug_log("User {$userid} is not using OAuth2 authentication (using: {$auth})");
            return true;
        }

        // Get the OAuth2 linked logins from the database
        $linked_logins = $DB->get_records('auth_oauth2_linked_login', ['userid' => $userid]);
        if (empty($linked_logins)) {
            self::debug_log("No OAuth2 linked logins found for user {$userid}");
            return true;
        }

        // Process all linked OAuth2 accounts
        $fields_updated = false;
        foreach ($linked_logins as $linked_login) {
            $oauthissuerid = $linked_login->issuerid;
            self::debug_log("Processing OAuth2 linked login with issuer ID: {$oauthissuerid}");

            // Process profile fields
            if (self::process_profile_fields($userid, $oauthissuerid)) {
                $fields_updated = true;
            }
        }

        // Trigger user_updated event to notify enrollment plugins about profile changes
        if ($fields_updated) {
            // Trigger user_updated event with proper creation method
            $context = \context_user::instance($userid);
            $event = \core\event\user_updated::create([
                'objectid' => $userid,
                'relateduserid' => $userid,
                'context' => $context
            ]);
            $event->trigger();
            
            self::debug_log("Triggered user_updated event for user {$userid} after profile fields update");
            
            // No direct dependency on enrol_attributes or other enrollment plugins
            // All enrollment plugins that listen to user_updated events will be notified
        }

        return true;
    }

    /**
     * Handle login event - specific processing for login events
     *
     * @param \core\event\user_loggedin $event
     * @return bool
     */
    public static function handle_login_event(\core\event\user_loggedin $event) {
        // Use the general user event handler
        return self::handle_user_event($event);
    }

    /**
     * Process profile fields for a user
     *
     * @param int $userid The user ID
     * @param int $oauthissuerid The OAuth2 issuer ID
     * @return bool True if profile fields were updated, False otherwise
     */
    private static function process_profile_fields($userid, $oauthissuerid) {
        global $DB, $CFG;

        // Get the OAuth configuration
        $config = oauth_config::get_oauthconfig($oauthissuerid);

        if (empty($config) || empty($config->has_profilefield_validation)) {
            self::debug_log("No valid configuration found for issuer ID: {$oauthissuerid}");
            return false;
        }

        // Check if within the configured time period
        if (!helper::within_datetime_range($config->profilefield_datetime_start ?? 0, $config->profilefield_datetime_end ?? 0)) {
            self::debug_log("Outside of configured date/time range for issuer ID: {$oauthissuerid}");
            return false;
        }

        $field = $config->profilefield;
        $updated = false;

        // Process custom profile field
        if (is_numeric($field)) {
            $profilefield = $config->profilefield;
            $fieldshortname = $DB->get_field('user_info_field', 'shortname', ['id' => $profilefield]);

            // Mapping incorrect
            if (empty($fieldshortname)) {
                self::debug_log("Invalid profile field mapping for field ID: {$profilefield}");
                return false;
            }

            $data = $DB->get_field('user_info_data', 'data', [
                'userid' => $userid,
                'fieldid' => $profilefield,
            ]);

            // Field is already filled
            if (!empty($data)) {
                self::debug_log("Profile field '{$fieldshortname}' already has a value: {$data}");
                return false;
            }

            // Create user object and save profile data
            $user = new \stdClass();
            $user->id = $userid;
            $user->{"profile_field_{$fieldshortname}"} = $config->profilefield_value;

            require_once($CFG->dirroot . '/user/profile/lib.php');
            profile_save_data($user);

            self::debug_log("Updated custom profile field '{$fieldshortname}' with value: {$config->profilefield_value}");
            $updated = true;
            
            // No specific cache purging for any enrollment plugin
            // Each plugin is responsible for managing its own cache
        } else {
            // Process standard user field
            $user = $DB->get_record('user', ['id' => $userid]);
            if (empty($user->$field)) {
                $user->$field = $config->profilefield_value;
                user_update_user($user, false);
                self::debug_log("Updated standard user field '{$field}' with value: {$config->profilefield_value}");
                $updated = true;
                
                // No specific cache purging for any enrollment plugin
                // Each plugin is responsible for managing its own cache
            } else {
                self::debug_log("Standard user field '{$field}' already has a value: {$user->$field}");
            }
        }

        return $updated;
    }

    /**
     * [REMOVED] The trigger_enrollments method has been removed to eliminate direct
     * dependencies on specific enrollment plugins. We now rely on standard Moodle
     * events that all enrollment plugins can listen to.
     */
    // Method removed to eliminate direct dependency on enrol_attributes

    /**
     * Log debug information
     *
     * @param string $message The message to log
     */
    private static function debug_log($message) {
        if (!self::DEBUG_MODE) {
            return;
        }

        // Log to error_log
        error_log("[OAUTH2DIRECTSSO_DEBUG] " . $message);

        // Log to Moodle debugging if enabled
        if (debugging()) {
            debugging($message, DEBUG_DEVELOPER);
        }
    }
}
