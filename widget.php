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


header("content-type:application/x-javascript");

require_once("config.inc.php");
require_once("api_search.php");

$course_code = $_GET['course_code'];
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

document.write('<div id="library_widget">\n');

<?php

if(DISPLAY_CATALOG_SEARCH)
{
	require_once("catalog_search_box.inc.php");
}

if(USE_LIBGUIDES)
{
	require_once("libguides.inc.php");
}

if(DISPLAY_CONTACT_INFO)
{
	require_once("contact_info.inc.php");
}

?>

document.write('</div>');