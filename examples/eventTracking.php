<?php

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

require_once(dirname(__FILE__) . '/../src/GMPTracking.php');

$options = array(
    'client_create_random_id' => true,
    'debug' => true
);

$gmp = new CoalaWeb\GMP\GMPTracking('UA-XXXXXXX-Y', $options);
$event = $gmp->createTracking('Event');
$event->setEventCategory('Category');
$event->setEventAction('Action');
$event->setEventLabel('Label');
$event->setEventValue(100);
$result = $gmp->sendTracking($event);

echo $result;