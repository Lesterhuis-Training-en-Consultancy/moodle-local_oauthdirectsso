<?php
// This plugin is being used for Moodle Open Source LMS - http://moodle.org/
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
 * Helper functions
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   moodle-local_oauthdirectsso
 * @copyright 02/07/2020 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

namespace local_oauthdirectsso;

use moodle_url;

/**
 * Helper functions
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   moodle-local_oauthdirectsso
 * @copyright 02/07/2020 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/
class helper {

    /**
     * Not used??
     */
    public static function store_wantsurl(): void {
        global $SESSION, $CFG;

        /// First, let's remember where the user was trying to get to before they got here.
        if (empty($SESSION->wantsurl)) {
            $SESSION->wantsurl = null;
            $referer = get_local_referer(false);
            if ($referer &&
                $referer !== $CFG->wwwroot &&
                $referer !== $CFG->wwwroot . '/' &&
                $referer !== $CFG->wwwroot . '/login/' &&
                strpos($referer, $CFG->wwwroot . '/login/?') !== 0 &&
                strpos($referer, $CFG->wwwroot . '/login/index.php') !== 0
            ) { // There might be some extra params such as ?lang=.
                $SESSION->wantsurl = $referer;
            }
        }
    }

    /**
     * @return moodle_url
     * @throws \dml_exception
     * @throws \moodle_exception
     */
    public static function get_url(): moodle_url {
        $url = get_config('local_oauthdirectsso', 'url');
        if (empty($url)) {
            $url = '#';
        }

        return new moodle_url($url);
    }

    /**
     * Check if a user has a matching IP
     *
     * @return bool
     * @throws \dml_exception
     */
    public static function has_valid_ipaddress(): bool {
        $ipaddresses = get_config('local_oauthdirectsso', 'restrict_ip_addresses');

        if (empty($ipaddresses)) {
            return true;
        }
        $clientip = getremoteaddr();
        $ipaddresses = explode(',', $ipaddresses);
        foreach ($ipaddresses as $ip) {
            if (address_in_subnet($clientip, trim($ip))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Redirect loggedin users
     *
     * @param string $wantsurl
     *
     * @throws \moodle_exception
     */
    public static function redirect_loggedin(string $wantsurl = ''): void {
        global $SESSION;

        if (!empty($wantsurl)) {
            redirect($wantsurl);
        }

        if (!empty($SESSION->wantsurl)) {
            redirect($SESSION->wantsurl);
        }

        redirect('/');
    }

}
