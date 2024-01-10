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
 * Renderer UI
 *
 * @license   Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
 *
 * @package   local_oauthdirectsso
 * @copyright 14/07/2020 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

/**
 * Class local_oauthdirectsso_renderer
 *
 * @package   local_oauthdirectsso
 * @copyright 14/07/2020 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 */
class local_oauthdirectsso_renderer extends plugin_renderer_base {

    /**
     * Render blocked message
     *
     * @return string
     * @throws moodle_exception
     */
    public function render_error_blocked() : string {
        return $this->render_from_template('local_oauthdirectsso/blocked', ['ipaddress' => getremoteaddr()]);
    }
}
