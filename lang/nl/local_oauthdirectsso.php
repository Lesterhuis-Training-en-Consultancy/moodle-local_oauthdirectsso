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

$string['pluginname'] = 'OATH direct SSO';
$string['privacy:metadata'] = 'Deze plugin bewaard geen gebruikersinformatie.';

// Settings.
$string['setting:url'] = 'Redirect url';
$string['setting:url_desc'] = 'De redirect URL is de URL van de OATH2 service, zonder <b>&wantsurl</b> en <b>&sesskey</b>.';
$string['setting:restrict_ip_addresses'] = 'Beperkte IP-adressen';
$string['setting:restrict_ip_addresses_desc'] = 'CSV format komma gescheidde IP adressen';

$string['error:invalid_ip'] = 'Je mag met deze URL niet inloggen omdat je niet op het netwerk zit dat is ingesteld.
 Klik hieronder om terug te gaan naar de standaard Moodle login pagina';

// Buttons.
$string['btn:back'] = 'Terug';