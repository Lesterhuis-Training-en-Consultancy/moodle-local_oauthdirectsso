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
 * Legacy configuration form
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   local_oauthdirectsso
 * @copyright 02/04/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/

namespace local_oauthdirectsso\form;

use moodleform;
use stdClass;

defined('MOODLE_INTERNAL') || die;

global $CFG;
require_once("$CFG->libdir/formslib.php");

/**
 * Class legacy_form
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   local_oauthdirectsso
 * @copyright 02/04/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/
class legacy_form extends moodleform {

    /**
     * Form definition
     *
     * @return void
     */
    protected function definition(): void {

        $mform = $this->_form;

        $mform->addElement(
            'text',
            'url',
            get_string('setting:url', 'local_oauthdirectsso'),
            ['size' => 100],
        );
        $mform->setType('url', PARAM_URL);

        $mform->addElement(
            'text',
            'restrict_ip_addresses',
            get_string('setting:restrict_ip_addresses', 'local_oauthdirectsso'),
            ['size' => 100],
        );
        $mform->setType('restrict_ip_addresses', PARAM_RAW);

        $this->add_action_buttons();

    }

    /**
     * Load legacy configuration values
     *
     * @return void
     */
    public function after_definition(): void {

        $legacyurl = get_config('local_oauthdirectsso', 'url');
        if ($legacyurl) {
            $urlelement = $this->_form->getElement('url');
            $urlelement->setValue($legacyurl);
        }

        $legacyiprestriction = get_config('local_oauthdirectsso', 'restrict_ip_addresses');
        if ($legacyiprestriction) {
            $iprestrictionelement = $this->_form->getElement('restrict_ip_addresses');
            $iprestrictionelement->setValue($legacyiprestriction);
        }

    }

    /**
     * Save data in legacy way, in plugin configuration.
     *
     * @param stdClass $data
     *
     * @return void
     */
    public function save(stdClass $data): void {

        unset($data->submitbutton);

        foreach ($data as $element => $value) {
            set_config($element, $value, 'local_oauthdirectsso');
        }

    }

}
