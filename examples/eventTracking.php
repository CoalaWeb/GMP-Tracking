<?php
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