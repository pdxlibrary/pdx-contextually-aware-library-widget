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


$eres = file_get_contents("http://library.pdx.edu/d2l/eres/widget.php?course_code=$course_code&role_name=".urlencode($role_name));

if(strcmp($eres,''))
{
	/*
	print("document.write('<ul data-role=\"listview\" data-inset=\"true\" data-dividertheme=\"b\" class=\"ui-listview ui-listview-inset ui-corner-all ui-shadow\">'); \n");
	print("document.write('<li data-corners=\"false\" data-shadow=\"false\" data-iconshadow=\"true\" data-wrapperels=\"div\" data-icon=\"arrow-r\" data-iconpos=\"right\" data-theme=\"a\" class=\"ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-first-child ui-last-child ui-btn-up-a\">'); \n");
	print("document.write('<div class=\"ui-btn-inner ui-li\">'); \n");
	print("document.write('<div class=\"ui-btn-text\">$eres</div>'); \n");
	print("document.write('<span class=\"ui-icon ui-icon-arrow-r ui-icon-shadow\">&nbsp;</span></div>'); \n");
	print("document.write('</li>'); \n");
	print("document.write('</ul>'); \n");
	print("document.write('<br />'); \n");
	*/
	print($eres);
}

?>