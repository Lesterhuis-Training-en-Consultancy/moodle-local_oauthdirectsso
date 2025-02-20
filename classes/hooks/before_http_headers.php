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
 * Before http headers
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   moodle-local_oauthdirectsso
 * @copyright 20/02/2025 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

namespace local_oauthdirectsso\hooks;

defined('MOODLE_INTERNAL') || die;

global $CFG;
require_once($CFG->dirroot . '/user/lib.php');

use local_oauthdirectsso\helper;
use local_oauthdirectsso\oauth_config;

/**
 * Class before_http_headers
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   moodle-local_oauthdirectsso
 * @copyright 20/02/2025 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/
class before_http_headers {

    /**
     * Cookie name
     *
     * @var string
     */
    protected const COOKIE_NAME = 'local_oauthdirectsso_oauthissuerid';

    /**
     * Things to execute during callback
     *
     * @return void
     */
    public static function callback(): void {
        global $USER, $_COOKIE, $DB;

        // Check if the user is logged in.
        if (!isloggedin()) {
            return;
        }

        // Check if the user is authenticated with OAuth2.
        if ($USER->auth !== 'oauth2') {
            return;
        }

        // Check if the cookie is set.
        if (empty($_COOKIE[self::COOKIE_NAME])) {
            return;
        }

        // Check if there is profile mapping.
        $oauthissuerid = (int) $_COOKIE[self::COOKIE_NAME] ?? 0;

        // Unset cookie no longer needed.
        setcookie(self::COOKIE_NAME, '', time() - 3600, '/');
        $config = oauth_config::get_oauthconfig($oauthissuerid);

        if (empty($config)
            && empty($config->has_profilefield_validation)) {
            return;
        }

        // Check if within the datetime range.
        if (!helper::within_datetime_range($config->profilefield_datetime_start, $config->profilefield_datetime_end)) {
            return;
        }

        $field = $config->profilefield;

        // Check custom field.
        if (is_numeric($field)) {
            $profilefield = $config->profilefield;
            $fieldshortname = $DB->get_field('user_info_field', 'shortname', ['id' => $profilefield]);

            // Mapping not correct.
            if (empty($fieldshortname)) {
                return;
            }

            $data = $DB->get_field('user_info_data', 'data', [
                'userid' => $USER->id,
                'fieldid' => $profilefield,
            ]);

            // User field is not empty.
            if (!empty($data)) {
                return;
            }

            profile_save_data(
                (object) [
                    'id' => $USER->id,
                    'profile_field_' . $fieldshortname => $config->profilefield_value,
                ]
            );

            return;
        }

        // User field is empty.
        if (empty($USER->$field)) {
            $USER->$field = $config->profilefield_value;
            user_update_user($USER, false);
        }

    }

}