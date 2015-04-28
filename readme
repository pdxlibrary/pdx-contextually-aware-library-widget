# Install Instructions

The application files must be uploaded to a server that can process PHP.

# Configuration

Depending on which features you want to include in the widget, you just need to edit the config.inc.php file to configure all the settings. 


```php

// Set whether to display catalog search box (values: true or false)
// The code to display the catalog search box must be added to catalog_search_box.inc.php
define("DISPLAY_CATALOG_SEARCH",true);

// Set whether to display subject and/or course guides from LibGuides
define("USE_LIBGUIDES",true);
// Set the institutional ID for your LibGuides instance, if USE_LIBGUIDES set to true
// The value for your IID can be found in the Admin Login URL for your LibGuides instance
define("LIBGUIDES_IID","");


// Set whether to display contact information
// The code to display the contact info must be added to contact_info.inc.php
define("DISPLAY_CONTACT_INFO",true);

```

## Caching (Optional) - there are currently two methods of caching built-in: Memcache OR Database. If you have access to either memcache or mysql, you can greatly reduce processing time by caching the output.
The default caching period is 1 day.

```php

/* caching options */

define("USE_CACHE",true);			// true = use caching, false = don't use caching
define("CACHE_TYPE","memcache");	// database or memcache

// memcache server connection info
define("CACHE_SERVER","");
define("CACHE_PORT","");
// cache entries older than the cutoff are considered too stale, so fresh data will be pulled instead
define("CACHE_CUTOFF",date("Y-m-d H:i:s",strtotime("1 day ago")));

// database server for caching connection info
define("DB_HOST","");
define("DB_USER","");
define("DB_PASS","");
define("DB_NAME","");

```

# Adding the Widget to D2L (or similar for other CMS's)

In D2L, you can make a widget box and add something like the following as the source of the widget:

```html

<p><link rel="stylesheet" type="text/css" href="//library.pdx.edu/d2l/widget.css" /></p>
<script src="//library.pdx.edu/d2l/widget.php?course_code={OrgUnitCode}&amp;course_name={OrgUnitName}&amp;role_name={RoleName}" type="text/javascript"></script>

```

```

Where:
//library.pdx.edu/d2l/widget.css is the path to the widget.css file you’ve placed on a server
//library.pdx.edu/d2l/widget.php is the path to the widget.php file you’ve placed on a server

```

## Tokens

```html

course_code={OrgUnitCode}&amp;course_name={OrgUnitName}&amp;role_name={RoleName}

```

These tokens will pass data from D2L about the currently logged in user. The widget.php file will use these tokens as input to determine what the widget should look like for the particular course/user. This means that if you integrate with an application for Course/Subject guides, you can display a relevant guide link for the course where the widget is being viewed. Similarly, if there are course reserves items, you can display those course-relevant items as well. The widget can be integrated with any other system that can be queried in some way using the data available from D2L tokens to add course or even user specific content. For instance, if you want to display a special message, link or anything for viewers who are "Faculty", this can be done as well.
