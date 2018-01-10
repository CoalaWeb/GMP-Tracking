<?php

defined('_JEXEC') or die('Restricted access');

/**
 * @package             CoalaWebGMP
 * @subpackage          CoalaWebGMP\Track
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

namespace CoalaWebGMP\Track;

/**
 * Class Track
 * @package CoalaWebGMP\Track
 */
class Track extends CoalaWebGMP
{
    /**
     * Track constructor.
     * @param null $config
     */
    public function __construct($config = null)
    {
    }

    /**
     * Send tracking data
     *
     * @param $config
     * @param $fields
     * @return mixed
     */
    public function sendTracking($config, $fields)
    {
        //set url
        if ($config['secureURL']) {
            $url = "https://ssl.google-analytics.com/collect"; //ssl
        } else {
            $url = "http://www.google-analytics.com/collect"; //non-ssl
        }

        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }

        //field url
        $fields_string = rtrim($fields_string, '&');    //remove end  "&"

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url); //url set
        curl_setopt($ch, CURLOPT_POST, count($fields)); //count no of param
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string); //POST data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //catch return data

        // Execute post
        $result = curl_exec($ch); //Exe

        // Status
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //close connection
        curl_close($ch); //close

        return $http_status;
    }
}
