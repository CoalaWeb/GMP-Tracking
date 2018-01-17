<?php

namespace CoalaWeb\GMP\Tools;

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

/**
 * Class ToolIP
 */
class ToolIP
{
    /**
     * Build users IP address
     *
     * @return string
     */
    public function getUserIP()
    {
        $ip = self::realGetUserIP();

        if ((strstr($ip, ',') !== false) || (strstr($ip, ' ') !== false)) {
            $ip = str_replace(' ', ',', $ip);
            $ip = str_replace(',,', ',', $ip);
            $ips = explode(',', $ip);
            $ip = '';
            while (empty($ip) && !empty($ips)) {
                $ip = array_pop($ips);
                $ip = trim($ip);
            }
        } else {
            $ip = trim($ip);
        }

        return $ip;
    }

    /**
     * Gets the users IP address
     *
     * @return string
     */
    private function realGetUserIP()
    {

        // Normally the $_SERVER superglobal is set
        if (isset($_SERVER)) {

            $ip_keys = array(
                'HTTP_CLIENT_IP',
                'HTTP_X_FORWARDED_FOR',
                'HTTP_X_FORWARDED',
                'HTTP_X_CLUSTER_CLIENT_IP',
                'HTTP_FORWARDED_FOR',
                'HTTP_FORWARDED',
                'REMOTE_ADDR'
            );

            foreach ($ip_keys as $key) {

                if (array_key_exists($key, $_SERVER) === true) {
                    foreach (explode(',', $_SERVER[$key]) as $ip) {
                        // trim for safety measures
                        $ip = trim($ip);
                        // attempt to validate IP
                        if ($this->validateIp($ip)) {
                            return $ip;
                        }
                    }
                }
            }

            return $this->validateIp($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        }

        // This part is executed on PHP running as CGI, or on SAPIs which do
        // not set the $_SERVER superglobal
        // If getenv() is disabled, you're screwed
        if (function_exists('getenv')) {

            $ip_keys = array(
                'HTTP_CLIENT_IP',
                'HTTP_X_FORWARDED_FOR',
                'HTTP_X_FORWARDED',
                'HTTP_X_CLUSTER_CLIENT_IP',
                'HTTP_FORWARDED_FOR',
                'HTTP_FORWARDED',
                'REMOTE_ADDR'
            );

            foreach ($ip_keys as $key) {
                if (getenv($key)) {
                    foreach (explode(',', getenv($key)) as $ip) {
                        // trim for safety measures
                        $ip = trim($ip);
                        // attempt to validate IP
                        if ($this->validateIp($ip)) {
                            return $ip;
                        }
                    }
                }
            }

            return $this->validateIp(getenv('REMOTE_ADDR')) ? getenv('REMOTE_ADDR') : '';
        }

        // Catch-all case for broken servers, apparently
        return '';
    }

    /**
     * Ensures an ip address is both a valid IP and does not fall
     * within a private network range.
     *
     * @param $ip
     * @return bool
     */
    private function validateIp($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) {
            return false;
        }
        return true;
    }
}
