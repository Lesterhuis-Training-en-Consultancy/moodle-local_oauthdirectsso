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
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   local_oauthdirectsso
 * @copyright 02/07/2020 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

defined('MOODLE_INTERNAL') || die;

// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment
// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder

// Default.
$string['pluginname'] = 'Oauth 2 direct SSO';
$string['privacy:metadata'] = 'This plugin doesn\'t save any user information';

// Settings.
$string['setting:url'] = 'Redirect url';
$string['setting:url_desc'] = 'The redirect url is the URL of the OATH2 service that is being used and that needs to be followed without <b>&wantsurl</b> and <b>&sesskey</b>';
$string['setting:restrict_ip_addresses'] = 'Restrict IP addresses';

// Buttons.
$string['btn:back'] = 'Back';
$string['btn:confirm'] = 'Confirm';
$string['btn:cancel'] = 'Cancel';

// Views.
$string['view:oauth'] = 'OAuth 2 overview';
$string['view:legacy'] = 'Legacy overview';

// Forms.
$string['form:select_oauth'] = 'Select OAuth 2 service';
$string['form:restrict_ip_addresses'] = 'Restrict IP addresses';
$string['form:restrict_ip_addresses_desc'] = 'CSV comma formatted IP addresses';
$string['form:no_oauths'] = 'No OAuth services are left for selection';
$string['form:has_profilefield_validation'] = 'Enable profile field validation';
$string['form:has_profilefield_validation_desc'] = ' ';
$string['form:make_a_selection'] = 'Make a selection';
$string['form:profilefield'] = 'Profile field';
$string['form:profilefield_value'] = 'Profile field value';
$string['form:profilefield_datetime_start'] = 'Start date';
$string['form:profilefield_datetime_end'] = 'End date';

// User profile fields.
$string['profilefield:city'] = 'user: - City';
$string['profilefield:department'] = 'user: - Department';
$string['profilefield:institution'] = 'user: - Institution';

// Tables.
$string['heading:table_name'] = 'OAuth name';
$string['heading:table_redirecturl'] = 'Redirect url';
$string['heading:table_iprestrictions'] = 'Restricted IP addresses';
$string['heading:table_actions'] = 'Actions';
$string['heading:table_profilefield'] = 'Profile field';
$string['heading:table_profilefield_datetime_start'] = 'Start date';
$string['heading:table_profilefield_datetime_end'] = 'End date';

// Mustache.
$string['mustache:legacy_url'] = 'Legacy configuration';
$string['mustache:add_directsso'] = 'Add OAuth 2 direct SSO';

// JS.
$string['js:confirm_title'] = 'Confirm action';
$string['js:confirm_delete'] = 'Are you sure you want to delete this?';

// Errors.
$string['error:no_oauth_enabled'] = 'No OAuth enabled';
$string['error:legacy_more_than_one_oauth'] = 'More than one OAuth configured. Please contact your administrator';
$string['error:invalid_ip'] = 'You cannot log in with this URL because you are not on the correct network. Please press the button below to return to the Moodle login page. Your IP adress is:';
$string['error:no_config_found'] = 'No OAuth configuration found';
$string['error:incorrect_field'] = 'Incorrect OAuth configuration field specified';
$string['error:invalid_ips'] = 'Invalid list of IP addresses provided';
$string['error:config_disabled'] = 'OAuth configuration has been disabled';
$string['error:oauth_doesnt_exist'] = 'OAuth provider does not exist';
$string['error:invalid_url'] = 'Invalid OAuth url provided';
$string['error:invalid_url_parameter'] = 'OAuth url has invalid parameter';
$string['error:expired_link_profilefield_datetime_start'] = 'This link is not yet active. It will be available starting on {$a}.
Please contact us for more details.';
$string['error:expired_link_profilefield_datetime_end'] = 'This link has expired and has been inactive since {$a}.
Please contact us for further assistance.';
