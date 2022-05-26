<?php
// This plugin is being used for Moodle Open Source LMS - http://moodle.org/
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
 * Redirect page.
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   moodle-local_oauthdirectsso
 * @copyright 02/07/2020 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/
require_once(__DIR__ . '/../../config.php');
defined('MOODLE_INTERNAL') || die;

$wantsurl = optional_param('wantsurl' , $CFG->wwwroot , PARAM_URL);
$sesskey = sesskey();

$PAGE->set_url('/local/oauthdirectsso/login.php' , [
    'wantsurl' => $wantsurl
]);
$PAGE->set_context(context_system::instance());


// Check IP.
if (\local_oauthdirectsso\helper::has_valid_ipaddress() === false) {
    /** @var local_oauthdirectsso_renderer $renderer **/
    $renderer = $PAGE->get_renderer('local_oauthdirectsso');

    echo $OUTPUT->header();
    echo $renderer->render_error_blocked();
    echo $OUTPUT->footer();
    exit;
}

if (isloggedin()) {
    \local_oauthdirectsso\helper::redirect_loggedin($wantsurl);
}

$url = \local_oauthdirectsso\helper::get_url();
$url->param('sesskey' , $sesskey);
if(!empty($wantsurl)){
    $url->param('wantsurl' , $wantsurl);
}

redirect($url);
