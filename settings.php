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
 * Plugin settings
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   local_oauthdirectsso
 * @copyright 02/07/2020 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

defined('MOODLE_INTERNAL') || die;

global $ADMIN;

if ($hassiteconfig) {

    // Add OAuth overview page to Server tab.
    $oauthurl = new moodle_url('/local/oauthdirectsso/view/oauth.php');
    $visiblename = get_string('pluginname', 'local_oauthdirectsso');

    $oauthexternalpage = new admin_externalpage(
        'local_oauthdirectsso_oauthview',
        $visiblename,
        $oauthurl,
        'moodle/site:config',
        false,
        context_system::instance(),
    );

    $ADMIN->add('server', $oauthexternalpage);

}
