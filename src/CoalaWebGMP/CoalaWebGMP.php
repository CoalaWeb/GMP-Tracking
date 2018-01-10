<?php

defined('_JEXEC') or die('Restricted access');

/**
 * @package             CoalaWeb
 * @subpackage          Measurement Protocol
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

namespace CoalaWebGMP;

use CoalaWebGMP\Options\Options;
use CoalaWebGMP\Tools\Tools;
use CoalaWebGMP\Track\Track;

class CoalaWebGMP
{
    protected $options;

    public function __construct($config = null)
    {

        $config = new Options($config); //Config
        $this->config = $config;
        $this->track = new Track(); //Track
        $this->tools = new Tools(); //IP Tools
    }

    public function config($tid, $ip = null, $ssl = false)
    {
        $this->config->setId($tid);
        $this->config->SSL($ssl);
        //if IP is null we will get it for you
        if ($ip == null) {
            $ip = $this->tools->getUserIP();
        }
        $this->config->setUip($ip);
    }

    /**
     * Page Tracking
     *
     * @param null $cid
     * @param $dh
     * @param $dp
     * @param $dt
     * @return array
     */
    public function Page($cid = null, $dh, $dp, $dt)
    {
        if ($cid == null) {
            $cid = $this->UUID();
        } //Generate new Unique User id
        return array(
            'v' => $this->config->options['v'],     // Version  1
            't' => "pageview",                      // Event hit type
            'tid' => $this->config->options['tid'], // Google Tracking ID
            'cid' => $cid,                          // Unique ID
            'dh' => $dh,                            // Document Host
            'dp' => $dp,                            // Document Page
            'dt' => $dt,                            // Document Title
            'uip' => $this->config->options['uip']  // User IP
        );
    }

    /**
     * Create Universal Unique User ID
     *
     * @return string
     */
    public function UUID()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

    }

    /**
     * Event Tracking
     *
     * @param null $cid
     * @param $category
     * @param $action
     * @param null $label
     * @param null $value
     * @return array
     */
    public function Event($cid = null, $category, $action, $label = null, $value = null)
    {
        if ($cid == null) {
            $cid = $this->UUID();
        } //Generate new Unique User id
        return array(
            'v' => $this->config->options['v'],     // Version  1
            't' => "event",                         // Event hit type
            'tid' => $this->config->options['tid'], // Google Tracking ID
            'cid' => $cid,                          // Unique ID
            'ec' => $category,                      // Event Category. Required.
            'ea' => $action,                        // Event Action. Required.
            'el' => $label,                         // Event label.
            'ev' => $value                          // Event value.
        );

    }

    /**
     * Track-Push data to server
     *
     * @param $param
     * @return mixed
     */
    public function track($param)
    {
        $config = $this->config->options;
        return $this->track->sendTracking($config, $param);
    }

    /**
     * Check if is a valid UUID v4
     *
     * @param $uuid
     * @return int
     */
    private function checkUuid($uuid)
    {
        return preg_match(
            '#^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$#i',
            $uuid
        );
    }
}
