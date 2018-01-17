<?php

namespace CoalaWeb\GMP\Tracking;

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

use CoalaWeb\GMP\Exception\MissingTrackingParameterException;
use CoalaWeb\GMP\Tools;

/**
 * Class Page
 * @package CoalaWeb\GMP\Tracking
 */
class Page extends AbstractTracking
{
    /**
     * Hold Tool class
     * @var
     */
    protected $tool;

    // document location
    /** @var String */
    private $documentLocation;

    // document host
    /** @var String */
    private $documentHost;

    // document path
    /** @var String */
    private $documentPath;

    // document title
    /** @var String */
    private $documentTitle;

    /**
     * Returns the Google Packet for Page Tracking
     *
     * @return array
     * @throws MissingTrackingParameterException
     */
    public function createPackage()
    {

        if (!$this->getDocumentPath()) {
            throw new MissingTrackingParameterException('Document path must be set for page view hits.');
        }

        return array(
            't' => 'pageview',
            'uip' => self::setUip(),
            // Content Information
            'dl' => $this->documentLocation,
            'dh' => $this->documentHost,
            'dp' => $this->documentPath,
        );
    }

    /**
     * Get the Document Host
     *
     * @return String
     */
    public function getDocumentHost()
    {
        return $this->documentHost;
    }

    /**
     * @param String $documentHost
     * @return Page
     */
    public function setDocumentHost($documentHost)
    {
        $this->documentHost = $documentHost;
        return $this;
    }

    /**
     * Get the Document Location
     *
     * @return String
     */
    public function getDocumentLocation()
    {
        return $this->documentLocation;
    }

    /**
     * @param String $documentLocation
     * @return Page
     */
    public function setDocumentLocation($documentLocation)
    {
        $this->documentLocation = $documentLocation;
        return $this;
    }

    /**
     * Get the Document Title
     *
     * @return String
     */
    public function getDocumentTitle()
    {
        return $this->documentTitle;
    }

    /**
     * @param String $documentTitle
     * @return Page
     */
    public function setDocumentTitle($documentTitle)
    {
        $this->documentTitle = $documentTitle;
        return $this;
    }

    /**
     * Get the Document Path
     *
     * @return String
     */
    public function getDocumentPath()
    {
        return $this->documentPath;
    }

    /**
     * @param String $documentPath
     * @return Page
     */
    public function setDocumentPath($documentPath)
    {
        $this->documentPath = $documentPath;
        return $this;
    }

    /**
     * Set the user IP
     *
     * @return string
     */
    public function setUip()
    {
        $this->tool = new Tools\ToolIP();
        $ip = $this->tool->getUserIP();
        return $ip;
    }
}
