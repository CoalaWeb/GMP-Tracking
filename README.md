# Measurement Protocol-PHP
Server side Google analytics - PHP

[Google Dev Guide](https://developers.google.com/analytics/devguides/collection/protocol/v1/devguide)

This is PHP client Library for Google Measurement Protocol

## Overview
Light weight and independent client Library to send data to Google Analytics.

## Type Support
 - Page Tracking
 - Event Tracking

# Getting Started

## Page Tracking

```php
<?php
require 'CoalaWebGMP.php';
$GA = new CoalaWebGMP();
$GA->config('UA-XXXXXX-Y',NULL,TRUE); //(Tracking ID,User IP,Secure URL)
$page = $GA->page("1534","localhost.com","ping","test"); //(unique User ID,Domain,Page,Title)
$GA->track($page); //(page-data) 
?>
```

### Config

```
$GA->config('UA-XXXXXX-Y',NULL,TRUE); //(Tracking ID, User IP, Secure URL)
```

 - Tracking ID (UA-XXXXXX-Y) - Required
 - User ip - Optional- Default = If null ystem will retrieve the user IP
 - Secure - Optional - Default = Non SSL (https) connection

### Page Data

```
$page=$GA->page("1534","localhost.com","ping","test"); //(unique User ID,Domain,Page,Title)
```

 - Unique User ID is the session identifier - Optional -  if null UUID will be generated
 - Hostname - Required
 - Page - Required
 - Title - Required
 
## Send Tracking Data
```
$GA->track($page);
```
Track will push to server.

Note: **Config** and **Track** are same for all Tracking Types.
 
## Event Tracking

```php
<?php

require 'CoalaWebGMP.php';
$GA= new Google_MP();
$GA->config('UA-XXXXXXX-Y',"1.2.56.4",FALSE);
$event=$GA->Event("14578954555445","Click","Fetch","net","1");
$GA->track($event);
?>
```

Note: For **Config** and **Track** see above.

### Event Data

```
$event=$GA->Event("14578954555445","Click","Fetch","net","1"); //(Unique User ID,Category,Action,Lable,Value)
```

- UUID is session identifier - Optional - If null one will be generated.
- Event Category - Required
- Event Action - Required
- Event Label - Required
- Eevent Value - Optional
