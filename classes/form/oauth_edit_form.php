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
 * Oauth configuration edit form.
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   local_oauthdirectsso
 * @copyright 10/01/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/

namespace local_oauthdirectsso\form;

use html_writer;
use local_oauthdirectsso\helper;
use moodleform;

/**
 * Class oauth_edit_form.
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   local_oauthdirectsso
 * @copyright 10/01/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/
class oauth_edit_form extends moodleform {

    /**
     * Form definition.
     *
     * @return void
     */
    protected function definition(): void {

        $mform = $this->_form;

        $id = optional_param('id', 0, PARAM_INT);
        $oauths = $this->get_oauths();

        if ($oauths || $id > 0) {

            $this->edit_element($mform, $oauths);

        } else {

            $mform->addElement(
                'html',
                html_writer::div(
                    get_string('form:no_oauths', 'local_oauthdirectsso'),
                    'alert alert-warning'
                )
            );
        }

        $this->add_action_buttons();
    }

    /**
     * Get the available OAuths that can be chosen from.
     *
     * @return array
     */
    private function get_oauths(): array {
        global $DB;

        $oauths = $DB->get_records_menu('oauth2_issuer', [], 'name ASC', 'id, name');
        $configuredoauths = $DB->get_fieldset_select('local_oauthdirectsso_config', 'oauthissuerid', '1=1');

        // Remove OAuths that are already have a config.
        foreach ($configuredoauths as $configuredoauth) {
            unset($oauths[$configuredoauth]);
        }

        return $oauths;
    }

    /**
     * Add the elements to the form.
     *
     * @param \MoodleQuickForm $mform
     * @param array $oauths
     * @return void
     */
    private function edit_element(\MoodleQuickForm $mform, array $oauths): void {
        $id = optional_param('id', null, PARAM_INT);

        if (empty($id)) {
            $mform->addElement(
                'select',
                'oauthissuerid',
                get_string('form:select_oauth', 'local_oauthdirectsso'),
                $oauths
            );
        }

        $mform->addElement(
            'text',
            'iprestrictions',
            get_string('form:restrict_ip_addresses', 'local_oauthdirectsso'),
        );
        $mform->setType('iprestrictions', PARAM_RAW);

        // Optional profile field validation.
        $mform->addElement(
            'static',
            'iprestrictions_desc',
            '',
            get_string('form:restrict_ip_addresses_desc', 'local_oauthdirectsso'),
        );

        // Date time picker with disable checkbox.
        $mform->addElement(
            'date_time_selector',
            'profilefield_datetime_start',
            get_string('form:profilefield_datetime_start', 'local_oauthdirectsso'),
            ['optional' => true]
        );

        $mform->addElement(
            'date_time_selector',
            'profilefield_datetime_end',
            get_string('form:profilefield_datetime_end', 'local_oauthdirectsso'),
            ['optional' => true]
        );

        $mform->addElement(
            'advcheckbox',
            'has_profilefield_validation',
            get_string('form:has_profilefield_validation', 'local_oauthdirectsso'),
            get_string('form:has_profilefield_validation_desc', 'local_oauthdirectsso'),
            null,
            [0, 1]
        );

        $profilefields = helper::get_profile_fields_choices();
        $mform->addElement(
            'select',
            'profilefield',
            get_string('form:profilefield', 'local_oauthdirectsso'),
            $profilefields
        );

        $mform->addElement(
            'text',
            'profilefield_value',
            get_string('form:profilefield_value', 'local_oauthdirectsso')
        );
        $mform->setType('profilefield_value', PARAM_TEXT);

        $mform->disabledIf('profilefield', 'has_profilefield_validation', 'eq', 0);
        $mform->disabledIf('profilefield_value', 'has_profilefield_validation', 'eq', 0);

    }

    /**
     * Add validation
     *
     * @param $data
     * @param $files
     * @return array
     */
    public function validation($data, $files): array {
        $errors = parent::validation($data, $files);

        if ($data['has_profilefield_validation'] == 1) {
            if (empty($data['profilefield'])) {
                $errors['profilefield'] = get_string('required');
            }

            if (empty($data['profilefield_value'])) {
                $errors['profilefield_value'] = get_string('required');
            }
        }

        return $errors;
    }
}
