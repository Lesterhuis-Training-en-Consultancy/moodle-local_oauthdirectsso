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
 * Local oauthdirectsso plugin legacy configuration support
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   local_oauthdirectsso
 * @copyright 02/04/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/

use local_oauthdirectsso\form\legacy_form;

require_once(__DIR__ . '/../../../config.php');

require_admin();

$context = context_system::instance();
$PAGE->set_context($context);

$url = new moodle_url('/local/oauthdirectsso/view/legacy.php');
$redirecturl = new moodle_url('/local/oauthdirectsso/view/oauth.php');
$PAGE->set_url($url);

$PAGE->set_title(get_string('view:legacy', 'local_oauthdirectsso'));
$PAGE->set_heading(get_string('view:legacy', 'local_oauthdirectsso'));

$form = new legacy_form();

if ($form->is_cancelled()) {
    redirect($redirecturl);
}

if ($data = $form->get_data()) {
    $form->save($data);
    redirect($redirecturl);
}

echo $OUTPUT->header();
echo $form->render();
echo $OUTPUT->footer();
