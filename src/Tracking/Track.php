<?php

namespace CoalaWeb\GMP\Tracking;

/**
 * @package     CoalaWeb\GMP
 * @author      Steven Palmer <support@coalaweb.com>
 * @git         https://github.com/CoalaWeb
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
 * along with this program.  If not, see <https://www.gnu.org/licenses/gpl.html>.
 */

defined('_JEXEC') or die;

/**
 * Class Track
 */
class Track
{

    /**
     * Send tracking info using CURL
     *
     * @param $fields
     * @return array
     */
    public function sendTracking($fields)
    {
        // Choose URL root type
        if ($fields['debug']) {
            // If using debug $result will hold response info about hit
            $url = 'https://www.google-analytics.com/debug/collect'; //debug
        } else {
            $url = 'https://www.google-analytics.com/collect'; //non-debug
        }

        // Merger fields into usable string
        $fieldsString = self::mergeFields($fields);

        // Open connection
        $ch = curl_init();

        // Set user agent
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);

        // Set URL
        curl_setopt($ch, CURLOPT_URL, $url);

        // Define header and version
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        // Post merged fields string
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsString);

        // Catch return data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute post and get response from RETURNTRANSFER
        $result = curl_exec($ch);

        // Check for errors
        $error = curl_error($ch);

        // Status - Should return 200
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close connection
        curl_close($ch); //close

        // Create array of info to return
        $trackInfo = [
            'result' => $result,
            'error' => $error,
            'status' => $status
        ];

        return $trackInfo;
    }

    /**
     * Merge fields into one string
     *
     * @param $fields
     * @return string
     */
    private function mergeFields($fields)
    {
        //Lets drop the debug element
        unset($fields['debug']);

        // The body of the post must include exactly 1 URI encoded payload and
        // must be no longer than 8192 bytes. See http_build_query.
        $content = http_build_query($fields);

        // The payload must be UTF-8 encoded.
        $content = utf8_encode($content);

        return $content;

    }
}
