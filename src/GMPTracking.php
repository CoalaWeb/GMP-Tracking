<?php

namespace CoalaWeb\GMP;

/**
 * @package             CoalaWeb\GMP
 * @author              Steven Palmer
 * @author url          https://coalaweb.com/
 * @author email        support@coalaweb.com
 * @license             GNU/GPL, see /assets/en-GB.license.txt
 * @copyright           Copyright (c) 2018 Steven Palmer All rights reserved.
 *
 * CoalaWeb GMP Tracking is free software: you can redistribute it and/or modify
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

defined('_JEXEC') or die;

// Autoloader created by composer
require_once(dirname(__FILE__) . '/../vendor/autoload.php');

use CoalaWeb\GMP\Tracking\Track;
use CoalaWeb\GMP\Tools\ToolIP;

/**
 * Class GMPTracking
 */
class GMPTracking
{
    /**
     * Track class
     * @var
     */
    protected $track;

    /**
     * Tool class
     * @var
     */
    protected $tool;

    /**
     * Default options
     * @var array
     */
    protected $options = array(
        'v' => 1,
        'debug' => FALSE
    );

    /**
     * GMPTracking constructor.
     * @param $tid
     */
    public function __construct($tid)
    {
        $this->setId($tid);
        $this->setUip();
    }

    /**
     * Page type tracking
     * @param $options
     * @return array
     */
    public function Page($options)
    {
        // ** Possible Options **
        // 'cid' Unique ID - 555
        // 'dh' Document Host - localhost.com
        // 'dp' Document Page - home
        // 'dt' Document Title - A Title

        $eventValues =  array(
            'v' => $this->options['v'],     // Version  1
            't' => "pageview",              // Type Page View
            'tid' => $this->options['tid'], // Tracking ID
            'cid' => $this->UUID(),         // Unique User ID
            'uip' => $this->options['uip']  // User IP
        );

        if (!isset($options->cid) || empty($options->cid)){
            //Generate new Unique User id
            $options['cid'] = $this->UUID();
        }

        $all = array_merge($eventValues, $options);

        return $all;
    }

    /**
     * Event type tracking
     * @param array $options
     * @return array
     */
    public function Event($options = array())
    {
        // ** Possible Options **
        // 'cid' Unique ID - 555
        // 'ec'  Event Category - Category 01
        // 'ea'  Event Action - Sent
        // 'el'  Event Label - Form Sent
        // 'ev'  Event Value - 123

        $eventValues = array(
            'v' => $this->options['v'],     // Version  1
            't' => "event",                 // Type
            'tid' => $this->options['tid'], // Tracking ID
            'cid' => $this->UUID(),         // Unique user ID
            'el' => NULL,                   // Default Event Label
            'ev' => 1                       // Default event value
        );

        if (!isset($options->cid) || empty($options->cid)){
            //Generate new Unique User id
            $options['cid'] = $this->UUID();
        }

        $all = array_merge($eventValues, $options);

        return $all;

    }

    /**
     * Track-Push data to server
     * @param $options
     * @return array
     */
    public function track($options)
    {
        $this->track = new Track();

        $trackInfo = $this->track->sendTracking($options);

        return $trackInfo;
    }

    /**
     * Create a Universal Unique User ID
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
     * Set the Tracking ID
     *
     * @param $id
     */
    public function setId($id)
    {
        $this->options['tid'] = $id;

    }

    /**
     * Set the user IP
     */
    public function setUip()
    {
        $this->tool = new ToolIP();
        $ip = $this->tool->getUserIP();
        $this->options['uip'] = $ip;
    }
}
