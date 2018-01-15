<?php
defined('_JEXEC') or die;

require_once(dirname(__FILE__) . '/../src/GMPTracking.php');

$gmp = new CoalaWeb\GMP\GMPTracking('UA-XXXXXXX-Y');
$options = array(
    'ec' => 'Category',
    'ea' => 'Action',
    'el' => 'Label'
);
$event = $gmp->event($options);
$result = $gmp->track($event);