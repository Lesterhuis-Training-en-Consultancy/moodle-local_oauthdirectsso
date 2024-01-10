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
 * Upgrade executions
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   local_oauthdirectsso
 * @copyright 09/01/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/

function xmldb_local_oauthdirectsso_upgrade(int $oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

    if ($oldversion < 2024010900) {

        // Define table local_oauthdirectsso_config to be created.
        $table = new xmldb_table('local_oauthdirectsso_config');

        // Adding fields to table local_oauthdirectsso_config.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '12', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('oauthissuerid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('iprestrictions', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('disabled', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table local_oauthdirectsso_config.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Adding indexes to table local_oauthdirectsso_config.
        $table->add_index('mdl_local_oauthdirectsso_issuerid', XMLDB_INDEX_UNIQUE, ['oauthissuerid']);

        // Conditionally launch create table for local_oauthdirectsso_config.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Oauthdirectsso savepoint reached.
        upgrade_plugin_savepoint(true, 2024010900, 'local', 'oauthdirectsso');
    }

    return true;

}
