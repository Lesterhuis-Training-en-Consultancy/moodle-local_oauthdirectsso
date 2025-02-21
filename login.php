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
 * Redirect page.
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   local_oauthdirectsso
 * @copyright 02/07/2020 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

use local_oauthdirectsso\helper;
use local_oauthdirectsso\oauth_config;

// phpcs:disable moodle.Files.RequireLogin.Missing
require_once(__DIR__ . '/../../config.php');

defined('MOODLE_INTERNAL') || die;

$SESSION->local_oauthdirectsso = new stdClass();
$SESSION->local_oauthdirectsso->legacy = false;
$SESSION->local_oauthdirectsso->oauthissuerid = 0;

$wantsurl = optional_param('wantsurl', $CFG->wwwroot, PARAM_URL);
$sesskey = sesskey();

$id = optional_param('id', 0, PARAM_INT);
if ($id === 0) {
    $SESSION->local_oauthdirectsso->legacy = true;
    $id = oauth_config::legacy_get_oauth_id();
}

$PAGE->set_url('/local/oauthdirectsso/login.php', [
    'id' => $id,
    'wantsurl' => $wantsurl,
]);
$PAGE->set_context(context_system::instance());

if ($error = oauth_config::check_configuration_requirements($id)) {
    $renderer = $PAGE->get_renderer('local_oauthdirectsso');

    echo $OUTPUT->header();
    echo $renderer->render_error($error);
    echo $OUTPUT->footer();
    exit;
}

if (isloggedin()) {
    helper::redirect_loggedin($wantsurl);
}

$url = oauth_config::get_oauth_url($id);
$url->param('sesskey', $sesskey);

if (!empty($wantsurl)) {
    $url->param('wantsurl', $wantsurl);
}

redirect($url);
