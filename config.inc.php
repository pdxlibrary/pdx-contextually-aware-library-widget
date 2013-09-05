<?php

/*

Portland State University Library - Contextually-Aware Library Widget

Copyright (c) 2012 Portland State University

Permission is hereby granted, free of charge, to any person obtaining a copy of this software 
and associated documentation files (the "Software"), to deal in the Software without restriction, 
including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, 
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial 
portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT 
LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN 
NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE 
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/


/* content options */

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



/* cachine options */

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



?>