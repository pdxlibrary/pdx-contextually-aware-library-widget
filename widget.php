<?php

/*

Portland State University Library - Contextually-Aware Library Widget

Copyright (c) 2012 Portland State University Library

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

header('Access-Control-Allow-Origin: *');  

require_once("config.inc.php");
require_once("api_search.php");

$course_code = $_GET['course_code'];
//$course_code = "OFFERING_PSY-451-001_201404";

$course_name = $_GET['course_name'];
$role_name = $_GET['role_name'];


/* Stats collection */
// create the file log.txt and confirm the application has write access to it
$filename = "log.txt";
if(is_writable($filename))
{
    $handle = fopen($filename, 'a');
	$entry = date('m/d/Y g:i:sa',strtotime('now')) . " | " . $course_code . " | " . $course_name . " | " . $role_name . "\n";
    fwrite($handle, $entry);
    fclose($handle);
}


?>

<link rel="stylesheet" href="//code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
<style>
.ui-content { padding: 0 5px;}
.ui-btn-inner {font-size:12px; }
.ui-body-c, .ui-overlay-c {background: transparent; background-image: none;}
input.ui-input-text, textarea.ui-input-text {font-size: 12px;}
.ui-fullsize .ui-btn-inner, .ui-fullsize .ui-btn-inner { font-size: 12px; }
</style>
<script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="//library.pdx.edu/d2l/js/jquery.mobile-1.3.2.js"></script>


<body onload="parent.alter_iframe_height(document.body.scrollHeight);">

<div id="library_widget" data-role="content">

<?php


if(USE_LIBGUIDES)
{
	require_once("libguides.inc.php");
}

if(SHOW_COURSE_RESERVES)
{
	require_once("course_reserves.inc.php");
}

if(DISPLAY_CATALOG_SEARCH)
{
	require_once("catalog_search_box.inc.php");
}

if(DISPLAY_CONTACT_INFO)
{
	require_once("contact_info.inc.php");
}

?>

</div>
</body>