<?php

namespace CoalaWeb\GMP;

/**
 * @package     CoalaWeb\GMP
 * @author      Steven Palmer <support@coalaweb.com>
 * @link        https://coalaweb.com/
 * @license     GNU/GPL, see /assets/en-GB.license.txt
 * @copyright   Copyright (c) 2018 Steven Palmer All rights reserved.
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
     * Default options
     * @var array
     */
    protected $options = array(
        'client_create_random_id' => true, // Create a random client id when the class can't fetch the current client id or none is provided by "client_id"
        'client_fallback_id' => 555, // Fallback client id when cid was not found and random client id is off
        'client_id' => null,    // Override client id
        'user_id' => null,  // Current user id
        'v' => 1, // API protocol version
        'debug' => FALSE // API end point URL
    );
    /** @var null */
    private $analyticsAccountUid = null;

    /**
     * GMPTracking constructor.
     * @param $analyticsAccountUid
     * @param array $options
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($analyticsAccountUid, $options = array())
    {
        if (empty($analyticsAccountUid)) {
            throw new Exception\InvalidArgumentException('Google Account/Tracking ID not provided!');
        }

        $this->analyticsAccountUid = $analyticsAccountUid;

        if (!empty($options)) {
            $this->setOptions(
                array_merge($this->options, $options)
            );
        }
    }

    /**
     * Return Analytics Account ID
     *
     * @return null
     */
    public function getAnalyticsAccountUid()
    {
        return $this->analyticsAccountUid;
    }

    /**
     * Set the Analytics Account ID
     *
     * @param null $analyticsAccountUid
     */
    public function setAnalyticsAccountUid($analyticsAccountUid)
    {
        $this->analyticsAccountUid = $analyticsAccountUid;
    }

    /**
     * Get hit type options from specific abstract class
     * @param $className
     * @param null $options
     * @return bool
     */
    public function createTracking($className, $options = null)
    {
        if (strstr(strtolower($className), 'abstracttracking')) {
            return false;
        }
        $class = 'CoalaWeb\GMP\Tracking\\' . $className;

        if ($options) {
            return new $class($options);
        }
        return new $class;
    }

    /**
     * Send all the options over to be sent as a hit
     * @param Tracking\AbstractTracking $tracking
     * @return array
     */
    public function sendTracking(Tracking\AbstractTracking $tracking)
    {
        $payloadData = $this->getTrackingPayloadData($tracking);

        $this->track = new Track();

        $trackInfo = $this->track->sendTracking($payloadData);

        return $trackInfo;
    }

    /**
     * Combine hit type options from abstract class to common options ready to send
     * @param Tracking\AbstractTracking $event
     * @return array
     */
    protected function getTrackingPayloadData(Tracking\AbstractTracking $event)
    {
        // Options from abstract class
        $payloadData = $event->getPackage();

        // Add common options
        $payloadData['v'] = $this->getOption('v');; // Protocol version
        $payloadData['tid'] = $this->analyticsAccountUid; // Account ID
        $payloadData['uid'] = $this->getOption('user_id'); // User ID
        $payloadData['cid'] = $this->getClientId(); // Client ID
        $payloadData['debug'] = $this->getOption('debug'); // API endpoint URL

        return array_filter($payloadData);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function getOption($key)
    {
        if (!isset($this->options[$key])) {
            return null;
        }
        return $this->options[$key];
    }

    /**
     * Return the Current Client Id
     *
     * @return string
     */
    public function getClientId()
    {
        $clientId = $this->getOption('client_id');

        if ($clientId) {
            return $clientId;
        }
        // collect user specific data
        if (isset($_COOKIE['_ga'])) {
            $gaCookie = explode('.', $_COOKIE['_ga']);
            if (isset($gaCookie[2])) {
                // check if uuid
                if ($this->checkUuid($gaCookie[2])) {
                    // uuid set in cookie
                    return $gaCookie[2];
                } elseif (isset($gaCookie[2]) && isset($gaCookie[3])) {
                    // google old client id
                    return $gaCookie[2] . '.' . $gaCookie[3];
                }
            }
        }
        // nothing found - fallback
        $generateClientId = $this->getOption('client_create_random_id');
        if ($generateClientId) {
            return $this->generateUuid();
        }
        return $this->getOption('client_fallback_id');
    }

    /**
     * Check if is a valid UUID v4
     *
     * @param $uuid
     * @return int
     */
    final private function checkUuid($uuid)
    {
        return preg_match(
            '#^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$#i',
            $uuid
        );
    }

    /**
     * Generate UUID v4 function - needed to generate a CID when one isn't available
     *
     * @author Andrew Moore http://www.php.net/manual/en/function.uniqid.php#94959
     * @return string
     */
    final private function generateUuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
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
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    /**
     * Return Options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set Options
     *
     * @param $options
     * @throws Exception\InvalidArgumentException
     */
    public function setOptions($options)
    {
        if (!is_array($options)) {
            throw new Exception\InvalidArgumentException(sprintf(
                '[%s] expects array; received [%s]',
                __METHOD__,
                gettype($options)
            ));
        }
        $this->options = $options;;
    }

    /**
     * Sets the used clientId
     *
     * @param $clientId
     */
    public function setClientId($clientId)
    {
        $this->setOption('client_id', $clientId);
    }

    public function setOption($key, $value)
    {
        if (isset($this->options[$key]) && is_array($this->options[$key]) && is_array($value)) {
            $oldValues = $this->options[$key];
            $value = array_merge($oldValues, $value);
        }
        $this->options[$key] = $value;
    }

}
