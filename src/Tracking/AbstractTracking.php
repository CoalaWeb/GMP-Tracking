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
 * Class AbstractTracking
 * @package CoalaWeb\GMP\Tracking
 */
abstract class AbstractTracking
{
    // non interactive hit
    /**
     * @var bool
     */
    private $nonInteractionHit = false;

    /**
     * @var array
     */
    private $customPayload = array();

    // event queue time difference
    /**
     * @var
     */
    private $queueTime;

    /**
     * @var
     */
    private $documentEncoding;

    /**
     * @var
     */
    private $documentReferrer;

    /**
     * @return array
     */
    public function getPackage()
    {
        $package = array_merge($this->createPackage(), array(

            // other
            'dr' => $this->documentReferrer,

            // system info
            'de' => $this->documentEncoding,

            // non interactive hit
            'ni' => $this->nonInteractionHit,

            // optional
            'qt' => $this->queueTime
        ));

        // custom payload data
        $package = array_merge($package, $this->customPayload);

        // remove all unused
        $package = array_filter($package, 'strlen');

        return $package;
    }

    /**
     * Get the transfer Packet from current hit type
     *
     * @return array
     */
    abstract public function createPackage();

    /**
     * Set the Tracking Processing Time to pass the qt param within this tracking request
     * ATTENTION!: Values greater than four hours may lead to hits not being processed.
     *
     * https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#qt
     *
     * @param $milliseconds
     */
    public function setQueueTime($milliseconds)
    {
        $this->queueTime = $milliseconds;
    }

    /**
     * Mark the Hit as Non Interactive
     *
     * @param $bool
     */
    public function setAsNonInteractionHit($bool)
    {
        $this->nonInteractionHit = (bool)$bool;
    }

    /**
     * @param String $documentEncoding
     */
    public function setDocumentEncoding($documentEncoding)
    {
        $this->documentEncoding = $documentEncoding;
    }


    /**
     * @param String $documentReferrer
     */
    public function setDocumentReferrer($documentReferrer)
    {
        $this->documentReferrer = $documentReferrer;
    }

}
