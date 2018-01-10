<?php

defined('_JEXEC') or die('Restricted access');

/**
 * @package             CoalaWebGMP
 * @subpackage          CoalaWebGMP\Options
 * @author              Steven Palmer
 * @author url          https://coalaweb.com/
 * @author email        support@coalaweb.com
 * @license             GNU/GPL, see /assets/en-GB.license.txt
 * @copyright           Copyright (c) 2018 Steven Palmer All rights reserved.
 *
 * CoalaWeb Measurement Protocol is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace CoalaWebGMP\Options;

/**
 * Class Options
 * @package CoalaWebGMP\Options
 */
class Options extends CoalaWebGMP
{
    /**
     * Options constructor.
     * @param null $config
     */
    public function __construct($config = null)
    {
        $this->options = array(
            'v' => 1,
            'tid' => '',
            'secureURL' => FALSE,
            'uip' => null);

    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->options['tid'] = $id;
    }

    /**
     * @param null $type
     */
    public function SSL($type = null)
    {
        if ($type != null) {
            $this->options['secureURL'] = $type;
        }
    }

    /**
     * @param $ip
     */
    public function setUip($ip)
    {
        $this->options['uip'] = $ip;
    }

}
