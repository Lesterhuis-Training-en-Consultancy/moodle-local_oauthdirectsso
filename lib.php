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
use core\output\inplace_editable;
use local_oauthdirectsso\oauth_config;

/**
 * Lib functions
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   local_oauthdirectsso
 * @copyright 10/01/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/

/**
 * Inplace editable callback
 *
 * @param string $itemtype
 * @param int $itemid
 * @param mixed $newvalue
 *
 * @return inplace_editable
 */
function local_oauthdirectsso_inplace_editable(string $itemtype, int $itemid, $newvalue): inplace_editable {
    global $PAGE;

    $PAGE->set_context(context_system::instance());

    // Store new value to $value to keep information on error message display.
    $value = $newvalue;

    // Ip restrictions need to be stored.
    if (strpos($itemtype, 'iprestrictions-oauthid-') === 0) {

        if (!empty($newvalue) && !oauth_config::valid_ips($newvalue)) {
            $newvalue = get_string('error:invalid_ips', 'local_oauthdirectsso');
        } else {
            oauth_config::update_value($itemid, 'iprestrictions', $newvalue);
        }
    }

    return new inplace_editable(
        'local_oauthdirectsso',
        $itemtype,
        $itemid,
        true,
        $newvalue,
        $value,
    );

}
