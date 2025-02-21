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
 * OAuth configuration functions
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   local_oauthdirectsso
 * @copyright 10/01/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/

namespace local_oauthdirectsso;

use moodle_exception;
use moodle_url;

/**
 * Class oauth_config
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   local_oauthdirectsso
 * @copyright 10/01/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/
class oauth_config {

    /**
     * The OAuth configuration table.
     */
    public const TABLE = 'local_oauthdirectsso_config';

    /**
     * Legacy supports only one OAuth provider.
     * We get the id of that OAuth provider from the set url.
     *
     * @return int
     */
    public static function legacy_get_oauth_id(): int {

        $url = get_config('local_oauthdirectsso', 'url');

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new moodle_exception('error:invalid_url', 'local_oauthdirectsso');
        }

        $query = parse_url($url, PHP_URL_QUERY);

        if (preg_match('/^id=(\d+)$/', $query, $matches)) {
            return (int) $matches[1];
        }

        throw new moodle_exception('error:invalid_url_parameter', 'local_oauthdirectsso');

    }

    /**
     * Create OAuth config record.
     *
     * @param object $data
     *
     * @return void
     */
    public static function create_oauthconfig(object $data): void {
        global $DB;

        // This is an update.
        if (!empty($data->id)) {
            $data->id = $DB->get_field(self::TABLE, 'id', ['oauthissuerid' => $data->id]);

            if (empty($data->id)) {
                throw new moodle_exception('error:no_config_found', 'local_oauthdirectsso');
            }

            $data->timemodified = time();
            $DB->update_record(self::TABLE, $data);

            return;
        }

        // Nothing to create if no issuer id has been provided.
        if (!isset($data->oauthissuerid)) {
            return;
        }

        $data->timecreated = time();
        $data->timemodified = time();

        $DB->insert_record(self::TABLE, $data);

    }

    /**
     * Delete an Oauth configuration.
     *
     * @param int $oauthissuerid
     *
     * @return void
     */
    public static function delete_oauthconfig(int $oauthissuerid): void {
        global $DB;

        $DB->delete_records(self::TABLE, ['oauthissuerid' => $oauthissuerid]);
    }

    /**
     * Get OAuth config record.
     *
     * @param int $oauthissuerid
     *
     * @return false|mixed|\stdClass
     */
    public static function get_oauthconfig(int $oauthissuerid) {
        global $DB;

        return $DB->get_record(self::TABLE, ['oauthissuerid' => $oauthissuerid]);

    }

    /**
     * Check if the OAuth itself exists.
     *
     * @param int $oauthissuerid
     *
     * @return bool
     */
    private static function oauth_exists(int $oauthissuerid): bool {
        global $DB;

        return $DB->record_exists('oauth2_issuer', ['id' => $oauthissuerid]);
    }

    /**
     * Update a value of a given field.
     *
     * @param int $oauthissuerid
     * @param string $field
     * @param mixed $value
     *
     * @return void
     */
    public static function update_value(int $oauthissuerid, string $field, mixed $value): void {
        global $DB;

        $oauthconfig = self::get_oauthconfig($oauthissuerid);

        if (empty($oauthconfig)) {
            throw new moodle_exception('error:no_config_found', 'local_oauthdirectsso');
        }

        if (!isset($oauthconfig->$field)) {
            throw new moodle_exception('error:incorrect_field', 'local_oauthdirectsso');
        }

        $oauthconfig->$field = $value;
        $oauthconfig->timemodified = time();

        $DB->update_record(self::TABLE, $oauthconfig);

    }

    /**
     * Check if all provided ids are valid.
     *
     * @param string $iprestrictions
     *
     * @return bool
     */
    public static function valid_ips(string $iprestrictions): bool {

        $iprestrictions = explode(',', $iprestrictions);

        foreach ($iprestrictions as $iprestriction) {
            $iprestriction = trim($iprestriction);

            if (!filter_var($iprestriction, FILTER_VALIDATE_IP)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get OAuth ip addresses.
     *
     * @param int $oauthissuerid
     *
     * @return false|mixed
     */
    public static function get_ipaddresses(int $oauthissuerid) {
        global $DB;

        return $DB->get_field(self::TABLE, 'iprestrictions', ['oauthissuerid' => $oauthissuerid]);
    }

    /**
     * Get URL to the actual OAuth method.
     *
     * @param int $oauthissuerid
     *
     * @return moodle_url
     */
    public static function get_oauth_url(int $oauthissuerid): moodle_url {
        global $SESSION;

        if ($SESSION->local_oauthdirectsso->legacy) {

            // Correctness of url has already been evaluated by now.
            $url = get_config('local_oauthdirectsso', 'url');

            return new moodle_url($url);
        }

        setcookie('local_oauthdirectsso_oauthissuerid', $oauthissuerid, time() + 3600, '/');

        return new moodle_url(
            '/auth/oauth2/login.php',
            [
                'id' => $oauthissuerid,
            ]
        );
    }

    /**
     * Check if all configuration requirements are met.
     *
     * @param int $oauthissuerid
     *
     * @return string|null
     */
    public static function check_configuration_requirements(int $oauthissuerid): ?string {
        global $SESSION;

        // Legacy access only ipaddress check.
        if ($SESSION->local_oauthdirectsso->legacy) {

            if (!helper::has_valid_ipaddress($oauthissuerid)) {
                return get_string('error:invalid_ip', 'local_oauthdirectsso') . ' [' . getremoteaddr() . ']';
            }

            return null;

        }

        $oauthconfig = self::get_oauthconfig($oauthissuerid);

        if (empty($oauthconfig)) {
            return get_string('error:no_config_found', 'local_oauthdirectsso');
        }

        if (!self::oauth_exists($oauthissuerid)) {
            // We can remove the config for the OAuth provider if it doesn't exist anymore.
            self::delete_oauthconfig($oauthissuerid);

            return get_string('error:oauth_doesnt_exist', 'local_oauthdirectsso');
        }

        if ($oauthconfig->disabled) {
            return get_string('error:config_disabled', 'local_oauthdirectsso');
        }

        // Check if the link is expired.
        if (!helper::within_datetime_range($oauthconfig->profilefield_datetime_start, $oauthconfig->profilefield_datetime_end)) {

            if(!empty($oauthconfig->expired_link_profilefield_datetime_start)
                && $oauthconfig->expired_link_profilefield_datetime_start < time()) {

                return get_string(
                    'error:expired_link_profilefield_datetime_start',
                    'local_oauthdirectsso',
                    date('Y-m-d H:i', $oauthconfig->expired_link_profilefield_datetime_start)
                );
            }

            return get_string(
                'error:expired_link_profilefield_datetime_end',
                'local_oauthdirectsso',
                date('Y-m-d H:i', $oauthconfig->profilefield_datetime_end)
            );
        }

        if (!helper::has_valid_ipaddress($oauthissuerid)) {
            return get_string('error:invalid_ip', 'local_oauthdirectsso') . ' [' . getremoteaddr() . ']';
        }

        return null;
    }

}
