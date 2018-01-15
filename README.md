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

```php
<?php
require_once(dirname(__FILE__) . '/src/GMPTracking.php');
$gmp = new CoalaWeb\GMP\GMPTracking('UA-XXXXXXX-Y');
$options = array(
    'dh' => 'localhost.com',
    'dp' => 'home',
    'dt' => 'Title'
);
$event = $gmp->page($options);
$result = $gmp->track($event);
?>
```

### Config

```
$gmp = new CoalaWeb\GMP\GMPTracking('UA-XXXXXXX-Y'); // Tracking ID
```
 - Tracking ID (UA-XXXXXX-Y) - Required

### Page Data

```
$options = array(
    'cid' => '555',
    'dh'  => 'localhost.com',
    'dp'  => 'home',
    'dt'  => 'Title'
);
$event = $gmp->page($options);
```

 - Unique User ID is the session identifier - Optional -  if null UUID will be generated
 - Hostname - Required
 - Page - Required
 - Title - Required
 
## Send Tracking Data
```
$gmp->track($page);
```
Track will push to server.

Note: **Config** and **Track** are same for all Tracking Types.
 
## Event Tracking

```php
<?php
require_once(dirname(__FILE__) . '/src/GMPTracking.php');
$gmp = new CoalaWeb\GMP\GMPTracking('UA-XXXXXXX-Y');
$options = array(
    'ec' => 'Category',
    'ea' => 'Action',
    'el' => 'Label',
    'ev' => 1
);
$event = $gmp->event($options);
$result = $gmp->track($event);
?>
```

Note: For **Config** and **Track** see above.

### Event Data

```
$options = array(
    'cid' => '555',
    'ec' => 'Category',
    'ea' => 'Action',
    'el' => 'Label',
    'ev' => 1
);
$event = $gmp->event($options);
```

- Event Unique User ID - Optional - If null one will be generated
- Event Category - Required
- Event Action - Required
- Event Label - Required
- Event Value - Optional
