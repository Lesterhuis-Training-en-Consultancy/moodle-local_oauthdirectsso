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
 * Lib functions
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   local_oauthdirectsso
 * @copyright 10/01/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/

use core\output\inplace_editable;
use local_oauthdirectsso\oauth_config;

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

    // Ip restrictions need to be stored.
    if (strpos($itemtype, 'iprestrictions-oauthid-') === 0) {
        oauth_config::update_value($itemid, 'iprestrictions', $newvalue);
    }

    return new inplace_editable(
        'local_oauthdirectsso',
        $itemtype,
        $itemid,
        true,
        $newvalue,
        $newvalue,
    );
}

/**
 * @deprecated since 4.5.3 - No longer used, replaced by event-based approach
 * Execute before http headers.
 *
 * @return void
 */
function local_oauthdirectsso_before_http_headers(): void {
    // This function is deprecated and no longer used.
    // We now use standard Moodle events instead (see db/events.php).
    debugging('Function local_oauthdirectsso_before_http_headers() is deprecated. ' .
        'The plugin now uses standard Moodle events instead.', DEBUG_DEVELOPER);
}
