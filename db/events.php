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
 * Event observers definition.
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   local_oauthdirectsso
 * @copyright 20/06/2025 LTNC B.V- Moodle gecertificeerd Partner
 * @author    Gemma Lesterhuis
 **/

defined('MOODLE_INTERNAL') || die();

$observers = [
    [
        'eventname' => '\core\event\user_created',
        'callback'  => '\local_oauthdirectsso\eventhandlers::handle_user_event',
        'priority'  => 10000, // High priority to ensure profile fields are updated first
        'internal'  => false,
    ],
    [
        'eventname' => '\core\event\user_loggedin',
        'callback'  => '\local_oauthdirectsso\eventhandlers::handle_login_event',
        'priority'  => 10000, // High priority to ensure profile fields are updated first
        'internal'  => false,
    ],
];
