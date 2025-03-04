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
$string['pluginname'] = 'Oauth2 direct SSO';
$string['privacy:metadata'] = 'Deze plugin bewaard geen gebruikersinformatie.';

// Settings.
$string['setting:url'] = 'Redirect url';
$string['setting:url_desc'] = 'De redirect URL is de URL van de Oauth2 service, zonder <b>&wantsurl</b> en <b>&sesskey</b>.';
$string['setting:restrict_ip_addresses'] = 'Beperkte IP-adressen';

// Buttons.
$string['btn:back'] = 'Terug';
$string['btn:confirm'] = 'Bevestig';
$string['btn:cancel'] = 'Annuleer';

// Views.
$string['view:oauth'] = 'OAuth 2 overzicht';
$string['view:legacy'] = 'Legacy overzicht';

// Forms.
$string['form:select_oauth'] = 'Selecteer OAuth 2 service';
$string['form:restrict_ip_addresses'] = 'Beperkte IP-adressen';
$string['form:restrict_ip_addresses_desc'] = 'CSV format komma gescheidde IP adressen';
$string['form:no_oauths'] = 'Er zijn geen OAuth services meer om te selecteren';
$string['form:has_profilefield_validation'] = 'Inschakelen Profielfield validatie';
$string['form:has_profilefield_validation_desc'] = 'Wanneer de validatie is ingeschakeld, wordt er gecontroleerd of het gekozen veld een waarde bevat nadat het account is aangemaakt via OAuth2. Als dit niet het geval is, zal de validatie dit tegenhouden. ';
$string['form:make_a_selection'] = 'Maak een selectie';
$string['form:profilefield'] = 'Profielveld';
$string['form:profilefield_value'] = 'Profielveld waarde';
$string['form:profilefield_datetime_start'] = 'Startdatum';
$string['form:profilefield_datetime_end'] = 'Einddatum';

// User profile fields.
$string['profilefield:city'] = 'user: - Plaats';
$string['profilefield:department'] = 'user: - Afdeling';
$string['profilefield:institution'] = 'user: - Organisatie';

// Tables.
$string['heading:table_name'] = 'OAuth naam';
$string['heading:table_redirecturl'] = 'Redirect url';
$string['heading:table_iprestrictions'] = 'Beperkte IP adressen';
$string['heading:table_actions'] = 'Acties';
$string['heading:table_profilefield'] = 'Profielveld';
$string['heading:table_profilefield_datetime_start'] = 'Startdatum';
$string['heading:table_profilefield_datetime_end'] = 'Einddatum';

// Mustache.
$string['mustache:legacy_url'] = 'Legacy configuratie';
$string['mustache:add_directsso'] = 'Voeg OAuth 2 direct SSO toe';

// JS.
$string['js:confirm_title'] = 'Bevestig actie';
$string['js:confirm_delete'] = 'Weet je zeker dat je dit wilt verwijderen?';

// Errors.
$string['error:no_oauth_enabled'] = 'Geen OAuth ingeschakeld';
$string['error:legacy_more_than_one_oauth'] = 'Meerdere OAuth geconfigureerd. Neem contact op met de administrator';
$string['error:invalid_ip'] = 'Je mag met deze URL niet inloggen omdat je niet op het netwerk zit dat is ingesteld.
 Klik hieronder om terug te gaan naar de standaard Moodle login pagina. Het IP adres waarmee je probeert in te loggen is:';
$string['error:no_config_found'] = 'Geen OAuth configuratie gevonden';
$string['error:incorrect_field'] = 'Incorrect OAuth configuratie veld gespecificeerd';
$string['error:invalid_ips'] = 'Ongeldige opmaak van IP adressen';
$string['error:config_disabled'] = 'OAuth configuratie is uitgeschakeld';
$string['error:oauth_doesnt_exist'] = 'OAuth provider bestaat niet';
$string['error:invalid_url'] = 'Ongeldige OAuth url';
$string['error:invalid_url_parameter'] = 'OAuth url heeft een ongeldige parameter';
$string['error:expired_link_profilefield_datetime_start'] = 'Deze link is nog niet actief. Hij zal beschikbaar zijn vanaf {$a}.
Neem contact met ons op voor meer informatie..';
$string['error:expired_link_profilefield_datetime_end'] = 'Deze link is verlopen en is sinds {$a} niet meer actief.
Neem contact met ons op voor verdere assistentie.';
