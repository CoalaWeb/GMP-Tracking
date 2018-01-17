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

/**
 * Class Event
 * @package CoalaWeb\GMP\Tracking
 */
class Event extends AbstractTracking
{
    /**
     * @var String $eventCategory
     */
    private $eventCategory;

    // Event Action
    /** @var  String */
    private $eventAction;

    // Event Label
    /** @var  String */
    private $eventLabel;

    // Event Label
    /** @var  String */
    private $eventValue;

    /**
     * Returns the Packet for Event Tracking
     *
     * @return array
     * @throws MissingTrackingParameterException
     */
    public function createPackage()
    {
        if (!$this->getEventCategory()) {
            throw new MissingTrackingParameterException('The Event category must be set.');
        }

        if (!$this->getEventAction()) {
            throw new MissingTrackingParameterException('The Event action must be set.');
        }

        return array(
            't' => 'event',
            'ec' => $this->getEventCategory(),
            'ea' => $this->getEventAction(),
            'el' => $this->getEventLabel(),
            'ev' => $this->getEventValue()
        );
    }

    /**
     * Get the Event Category
     *
     * @return Event|String
     */
    public function getEventCategory()
    {
        return $this->eventCategory;
    }

    /**
     * Set the Event Category (Required)
     *
     * @param $eventCategory
     * @return $this
     */
    public function setEventCategory($eventCategory)
    {
        $this->eventCategory = $eventCategory;
        return $this;
    }

    /**
     * Get the Event Action
     *
     * @return Event|String
     */
    public function getEventAction()
    {
        return $this->eventAction;
    }

    /**
     * Set the Event Action (Required)
     *
     * @param $eventAction
     * @return $this
     */
    public function setEventAction($eventAction)
    {
        $this->eventAction = $eventAction;
        return $this;
    }

    /**
     * Get the Event Label
     *
     * @return Event|String
     */
    public function getEventLabel()
    {
        return $this->eventLabel;
    }

    /**
     * Set the Event Label
     *
     * @param $eventLabel
     * @return $this
     */
    public function setEventLabel($eventLabel)
    {
        $this->eventLabel = $eventLabel;
        return $this;
    }

    /**
     * Get the Event Value
     *
     * @return Event|String
     */
    public function getEventValue()
    {
        return $this->eventValue;
    }

    /**
     * Set the Event Value
     *
     * @param $eventValue
     * @return $this
     */
    public function setEventValue($eventValue)
    {
        $this->eventValue = $eventValue;
        return $this;
    }
}
