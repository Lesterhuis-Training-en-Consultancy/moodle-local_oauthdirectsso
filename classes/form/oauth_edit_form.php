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
 * Oauth configuration edit form
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   moodle-local_oauthdirectsso
 * @copyright 10/01/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/

namespace local_oauthdirectsso\form;

use html_writer;
use local_oauthdirectsso\oauth_config;
use moodleform;

/**
 * Class oauth_edit_form
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   moodle-local_oauthdirectsso
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

        $oauths = $this->get_oauths();

        if ($oauths) {

            $mform->addElement(
                'select',
                'oauthissuerid',
                get_string('form:select_oauth', 'local_oauthdirectsso'),
                $oauths
            );

            $mform->addElement(
                'text',
                'iprestrictions',
                get_string('form:restrict_ip_addresses', 'local_oauthdirectsso'),
            );
            $mform->setType('iprestrictions', PARAM_RAW);

            $mform->addElement(
                'static',
                'iprestrictions_desc',
                '',
                get_string('form:restrict_ip_addresses_desc', 'local_oauthdirectsso'),
            );

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

}
