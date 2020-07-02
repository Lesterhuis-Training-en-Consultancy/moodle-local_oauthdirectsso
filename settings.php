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
 * Plugin settings
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   moodle-local_oauthdirectsso
 * @copyright 02/07/2020 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/
defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_oauthdirectsso',
        new lang_string('pluginname', 'local_oauthdirectsso'));

    $settings->add(new admin_setting_configtext('local_oauthdirectsso/url',
        new lang_string('setting:url', 'local_oauthdirectsso'),
        new lang_string('setting:url_desc', 'local_oauthdirectsso'),
        '', PARAM_URL));

    $settings->add(new admin_setting_configtext('local_oauthdirectsso/restrict_ip_addresses',
        new lang_string('setting:restrict_ip_addresses', 'local_oauthdirectsso'),
        new lang_string('setting:restrict_ip_addresses_desc', 'local_oauthdirectsso'),
        '', PARAM_RAW));

    $ADMIN->add('localplugins', $settings);
}