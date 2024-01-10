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
 * Oauth overview table
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   local_oauthdirectsso
 * @copyright 09/01/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/

namespace local_oauthdirectsso\table;

use core\output\inplace_editable;
use html_writer;
use moodle_url;
use stdClass;
use table_sql;

defined('MOODLE_INTERNAL') || die;

global $CFG;
require_once($CFG->libdir . '/tablelib.php');

/**
 * Class auth_overview_table
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   local_oauthdirectsso
 * @copyright 09/01/2024 LdesignMedia.nl - Luuk Verhoeven
 * @author    Vincent Cornelis
 **/
class oauth_overview_table extends table_sql {

    /**
     * Constructor.
     *
     * @param string $uniqueid
     */
    public function __construct(string $uniqueid) {

        $this->sql = new stdClass();
        $this->sql->fields = 'oi.id, oi.name, oc.iprestrictions, oc.disabled';
        $this->sql->from = '{local_oauthdirectsso_config} oc
                            LEFT JOIN {oauth2_issuer} oi ON oi.id = oc.oauthissuerid';
        $this->sql->where = '1=1';
        $this->sql->params = [];

        parent::__construct($uniqueid);
    }

    /**
     * Get the corresponding redirect url.
     *
     * @param object $row
     *
     * @return string
     */
    public function col_redirecturl(object $row): string {
        return (new moodle_url('/auth/oauth2/login.php', ['id' => $row->id]))->out(false);
    }

    /**
     * Editable IP restrictions.
     *
     * @param object $row
     *
     * @return string
     */
    public function col_iprestrictions(object $row): string {
        global $OUTPUT;

        $editablerestrictions = new inplace_editable(
            'local_oauthdirectsso',
            'iprestrictions-oauthid-' . $row->id,
            $row->id,
            true,
            $row->iprestrictions,
            $row->iprestrictions,
        );

        return $editablerestrictions->render($OUTPUT);

    }

    /**
     * Get actions that can be performed for the row.
     *
     * @param object $row
     *
     * @return string
     */
    public function col_actions(object $row): string {

        $disabledurl = new moodle_url(
            '/local/oauthdirectsso/view/oauth.php',
            [
                'action' => 'set_disabled',
                'id' => $row->id,
                'value' => (int) $row->disabled === 0 ? 1 : 0,
            ]
        );

        $icon = (int) $row->disabled === 0 ? 'fa fa-eye' : 'fa fa-eye-slash';

        $actions = html_writer::link(
            $disabledurl->out(false),
            '',
            ['class' => $icon . ' btn btn-secondary']
        );

        $deleteurl = new moodle_url(
            '/local/oauthdirectsso/view/oauth.php',
            [
                'action' => 'delete',
                'id' => $row->id
            ]
        );

        $actions .= html_writer::link(
            $deleteurl->out(false),
            '',
            ['class' => 'btn btn-danger fa fa-trash oauth-delete ml-2']
        );

        return $actions;
    }

}
