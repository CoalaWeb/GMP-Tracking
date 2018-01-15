<?php
defined('_JEXEC') or die;

require_once(dirname(__FILE__) . '/../src/GMPTracking.php');

$gmp = new CoalaWeb\GMP\GMPTracking('UA-XXXXXXX-Y');
$options = array(
    'dh' => 'localhost.com',
    'dp' => 'home',
    'dt' => 'Title'
);
$event = $gmp->page($options);
$result = $gmp->track($event);