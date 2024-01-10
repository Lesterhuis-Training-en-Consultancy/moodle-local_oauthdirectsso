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
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   local_oauthdirectsso
 * @copyright 10/01/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/

namespace local_oauthdirectsso;

use moodle_exception;

/**
 * Class oauth_config
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   local_oauthdirectsso
 * @copyright 10/01/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/
class oauth_config {

    public const TABLE = 'local_oauthdirectsso_config';

    /**
     * Create OAuth config record.
     *
     * @param object $data
     *
     * @return void
     */
    public static function create_oauthconfig(object $data) {
        global $DB;

        // Nothing to create if no issuer id has been provided.
        if (!isset($data->issuerid)) {
            return;
        }

        $data->timecreated = time();
        $data->timemodified = time();

        $DB->insert_record(self::TABLE, $data);

    }

    /**
     * Get OAuth config record.
     *
     * @param int $oauthissuerid
     *
     * @return false|mixed|\stdClass
     */
    private static function get_oauthconfig(int $oauthissuerid) {
        global $DB;

        return $DB->get_record(self::TABLE, ['oauthissuerid' => $oauthissuerid]);

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

}
