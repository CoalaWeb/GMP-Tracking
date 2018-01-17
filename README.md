# Measurement Protocol-PHP
Server side Google analytics - This is PHP client Library for Google Measurement Protocol [Google Dev Guide](https://developers.google.com/analytics/devguides/collection/protocol/v1/devguide)

## Overview
Light weight and independent client Library to send data to Google Analytics. 

**Note: Composer is only needed to create the auto load files.**

## Type Support
 - Page Tracking
 - Event Tracking

# Getting Started

## Page Tracking


    <?php
    require_once(dirname(__FILE__) . '/src/GMPTracking.php');
    
    $options = array();
    
    $gmp = new CoalaWeb\GMP\GMPTracking('UA-XXXXXXX-Y', $options);
    $page = $gmp->createTracking('Page');
    
    $page->setDocumentLocation('http://example.com/home?a=b');
    $page->setDocumentHost('example.com');
    $page->setDocumentPath('/path/example');
    $page->setDocumentTitle('Example Title');
    
    $result = $gmp->sendTracking($page);
    
    // Returns an array with result, status and errors. Very useful when using the debug option
    echo $result;
    ?>


### Configuration Options

#### Below are the current options and their default states.

    $options = array(
        'client_create_random_id' => true, // Create a random client id when the class can't fetch the current client id or none is provided by "client_id"
        'client_fallback_id' => 555, // Fallback client id when cid was not found and random client id is off
        'client_id' => null,    // Override client id
        'user_id' => null,  // Current user id
        'v' => 1, // API protocol version
        'debug' => FALSE // API end point URL
    );


    $gmp = new CoalaWeb\GMP\GMPTracking('UA-XXXXXXX-Y', $options);
    
 - Tracking ID (UA-XXXXXX-Y) - Required
 - Options array - Optional (Omit if not needed)

### Page Data

    $page->setDocumentLocation('http://example.com/home?a=b');
    $page->setDocumentHost('example.com');
    $page->setDocumentPath('/path/example');
    $page->setDocumentTitle('Example Title');


 - Document location URL - Optional
 - Document Host Name - Optional
 - Document Path - Required
 - Document Title - Optional
 
## Send Tracking Data
```
$gmp->sendTracking($page);
```
Note: If you wish to debug your settings set the **debug** option to **true** and then assign **sendTracking** to a variable to be echoed.

```
$options = array(
    'debug' => true
);

$result = $gmp->sendTracking($page);
echo $result;
```

## Event Tracking

    <?php
    require_once(dirname(__FILE__) . '/src/GMPTracking.php');
    
    $options = array();
    $gmp = new CoalaWeb\GMP\GMPTracking('UA-XXXXXXX-Y', $options);
    
    $event = $gmp->createTracking('Event');
    $event->setEventCategory('Category');
    $event->setEventAction('Action');
    $event->setEventLabel('Label');
    $event->setEventValue(1);
    
    $result = $gmp->sendTracking($event);
    
    // Returns an array with result, status and errors. Very useful when using the debug option
    echo $result;
    ?>


Note: The **Configuration Options** and **Send Tracking** settings are the same for hit types.

### Event Data

    $event->setEventCategory('Category');
    $event->setEventAction('Action');
    $event->setEventLabel('Label');
    $event->setEventValue(1);

- Event Category - Required
- Event Action - Required
- Event Label - Optional
- Event Value - Optional

## Useful Info

### Response Codes

The Measurement Protocol will return a 2xx status code if the HTTP request was received. The Measurement Protocol does not return an error code if the payload data was malformed, or if the data in the payload was incorrect or was not processed by Google Analytics.

If you do not get a 2xx status code, you should NOT retry the request. Instead, you should stop and correct any errors in your HTTP request.