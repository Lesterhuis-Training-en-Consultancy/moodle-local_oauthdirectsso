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
 * OAuth overview page
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   local_oauthdirectsso
 * @copyright 08/01/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/

namespace local_oauthdirectsso\output;

use local_oauthdirectsso\table\oauth_overview_table;
use renderable;
use renderer_base;
use templatable;

/**
 * Class oauth_overview
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   local_oauthdirectsso
 * @copyright 08/01/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/
class oauth_overview implements renderable, templatable {

    /**
     * Get the data to export to template
     *
     * @param renderer_base $output
     *
     * @return array
     */
    public function export_for_template(renderer_base $output): array {

        $addurl = new \moodle_url('/local/oauthdirectsso/view/oauth.php', ['action' => 'add']);

        return [
            'addurl' => $addurl,
            'table' => $this->get_table(),
        ];
    }

    /**
     * Get the OAuth overview table
     *
     * @return false|string
     */
    private function get_table() {
        global $PAGE;

        ob_start();

        $table = new oauth_overview_table('oauth_overview_xbrgekhwer');

        $table->set_attribute('cellspacing', '0');
        $table->set_attribute('class', 'generaltable generalbox');
        $table->initialbars(true);
        $table->define_baseurl($PAGE->url);

        $columns = [
            'name',
            'redirecturl',
            'iprestrictions',
            'actions',
        ];

        $table->define_headers(array_map(static function($val) {
            return get_string('heading:table_' . $val, 'local_oauthdirectsso');
        }, $columns));

        $table->define_columns($columns);

        $table->collapsible(false);
        $table->sortable(true, 'name');
        $table->no_sorting('redirecturl');
        $table->no_sorting('iprestrictions');
        $table->no_sorting('action');

        $table->is_downloadable(false);

        $table->out(25, true);

        return ob_get_clean();
    }

}
