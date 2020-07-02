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
 * EN language file
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   moodle-local_oauthdirectsso
 * @copyright 02/07/2020 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

defined('MOODLE_INTERNAL') || die;

$string['pluginname'] = 'Oauthdirect SSO';
$string['privacy:metadata'] = 'This plugin doesn\'t save any user information';

// Settings.
$string['setting:url'] = 'Redirect url';
$string['setting:url_desc'] = 'The redirect url that needs to be followed without <b>&sesskey</b> and <b>&wantsurl</b>';
$string['setting:restrict_ip_addresses'] = 'Restrict IP addresses';
$string['setting:restrict_ip_addresses_desc'] = 'CSV formatted IP addresses';