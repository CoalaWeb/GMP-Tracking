# Measurement Protocol-PHP
Server side Google analytics - This is PHP client Library for Google Measurement Protocol [Google Dev Guide](https://developers.google.com/analytics/devguides/collection/protocol/v1/devguide)

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
$gmp = new CoalaWebGMP();
$gmp->config('UA-XXXXXX-Y',NULL,TRUE); //(Tracking ID, User IP, Secure URL)
$page = $gmp->page('Unique User ID', 'Domain', 'Page', 'Title');
$gmp->track($page); // Send tracking information
?>
```

### Config

```
$gmp->config('UA-XXXXXX-Y',NULL,TRUE); //(Tracking ID, User IP, Secure URL)
```

 - Tracking ID (UA-XXXXXX-Y) - Required
 - User ip - Optional- Default = Null - system will retrieve the user IP
 - Secure - Optional - Default = False - Non SSL(https) connection

### Page Data

```
$page = $gmp->page('Unique User ID', 'Domain', 'Page', 'Title');
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

require 'CoalaWebGMP.php';
$gmp = new CoalaWebGMP();
$gmp->config('UA-XXXXXXX-Y',NULL,TRUE); //(Tracking ID, User IP, Secure URL)
$event = $gmp->event("Unique User ID", "Category", "Action", "Label", "Value");
$gmp->track($event);
?>
```

Note: For **Config** and **Track** see above.

### Event Data

```
$event = $gmp->Event("Unique User ID", "Category", "Action", "Label", "Value");
```

- Event Unique User ID - Optional - If null one will be generated
- Event Category - Required
- Event Action - Required
- Event Label - Required
- Event Value - Optional
