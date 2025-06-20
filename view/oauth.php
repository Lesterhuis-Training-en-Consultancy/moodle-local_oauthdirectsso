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
 * Admin external page for OAUTH 2 overview
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   local_oauthdirectsso
 * @copyright 08/01/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/

use local_oauthdirectsso\form\oauth_edit_form;
use local_oauthdirectsso\oauth_config;
use local_oauthdirectsso\output\oauth_overview;

require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ . '/../../../lib/adminlib.php');
defined('MOODLE_INTERNAL') || die;

$id = optional_param('id', null, PARAM_INT);
$action = optional_param('action', null, PARAM_TEXT);
$value = optional_param('value', null, PARAM_RAW);

admin_externalpage_setup('local_oauthdirectsso_oauthview');

$context = context_system::instance();
$PAGE->set_context($context);

$url = new moodle_url('/local/oauthdirectsso/view/oauth.php', [
    'action' => $action,
    'id' => $id,
]);

$PAGE->set_url($url);

$PAGE->set_title(get_string('view:oauth', 'local_oauthdirectsso'));
$PAGE->set_heading(get_string('view:oauth', 'local_oauthdirectsso'));

switch ($action) {
    case 'add':
    case 'edit':
        $form = new oauth_edit_form($PAGE->url);

        if ($id) {
            $oauthconfig = oauth_config::get_oauthconfig($id);
            $form->set_data($oauthconfig);
        }

        if ($form->is_cancelled()) {
            $url->remove_all_params();
            redirect($url);
        }

        if ($data = $form->get_data()) {

            if ($id) {
                $data->id = $id;
            }

            oauth_config::create_oauthconfig($data);

            $url->remove_all_params();
            redirect($url);
        }

        echo $OUTPUT->header();
        echo $form->render();
        echo $OUTPUT->footer();

        break;

    case 'set_disabled':
        oauth_config::update_value($id, 'disabled', $value);
        $url->remove_all_params();
        redirect($url);
        break;

    case 'delete':
        oauth_config::delete_oauthconfig($id);
        $url->remove_all_params();
        redirect($url);
        break;

    default:
        $page = new oauth_overview();

        echo $OUTPUT->header();
        echo $OUTPUT->render($page);
        echo $OUTPUT->footer();

}
