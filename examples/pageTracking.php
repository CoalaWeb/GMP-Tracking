<?php
defined('_JEXEC') or die;

require_once(dirname(__FILE__) . '/../src/GMPTracking.php');

$options = array(
    'client_create_random_id' => false,
    'debug' => true
);

$gmp = new CoalaWeb\GMP\GMPTracking('UA-XXXXXXX-Y', $options);
$page = $gmp->createTracking('Page');

$page->setDocumentLocation('http://example.com/home?a=b');
$page->setDocumentHost('example.com');
$page->setDocumentPath('/path/example');
$page->setDocumentTitle('Example Title');

$result = $gmp->sendTracking($page);

echo $result;