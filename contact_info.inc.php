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

?>

function OpenLNetWindow()
{
	open("http://stats.lib.pdx.edu/d2l.php?course_code=<?php print($course_code); ?>&role_name=<?php print($role_name); ?>&url=http://www.oregonlibraries.net/widget/psu-d2l", "Chat", "height=480,width=230,toolbar=no,menubar=no,resizable=no,scrollbars=yes");
}

document.write('<div id="library_contact_us" style="text-align:center">');
document.write('<table align="center" cellpadding="4">');
document.write('<tr><td><span style="font-size:14px;"><a href="http://stats.lib.pdx.edu/d2l.php?course_code=<?php print($course_code); ?>&role_name=<?php print($role_name); ?>&url=http://library.pdx.edu/askus.html" style="font-weight:bold;">Ask<br>Us!</a></span></td>');
document.write('<td><a target="_blank" href="http://stats.lib.pdx.edu/d2l.php?course_code=<?php print($course_code); ?>&role_name=<?php print($role_name); ?>&url=http://library.pdx.edu/web_forms/ask_a_librarian.php"><img src="https://library.pdx.edu/images/ask_us/email.gif" border="0" /></a></td>');
document.write('<td><a href="javascript:OpenLNetWindow();"><img src="https://library.pdx.edu/images/ask_us/chat.gif" border="0" /></a></td>');
document.write('<td><a target="_blank" href="http://stats.lib.pdx.edu/d2l.php?course_code=<?php print($course_code); ?>&role_name=<?php print($role_name); ?>&url=http://library.pdx.edu/askus.html"><img src="https://library.pdx.edu/images/ask_us/phone.gif" border="0" /></a></td>');
document.write('<td><a href="http://stats.lib.pdx.edu/d2l.php?course_code=<?php print($course_code); ?>&role_name=<?php print($role_name); ?>&url=http://library.pdx.edu/askus.html"><img src="https://library.pdx.edu/images/ask_us/text.gif" border="0" /></a></td></tr></table>');
document.write('</div>');

document.write('<center>');
document.write('<div style="line-height:23px; font-size:11px"><a target="_blank" href="http://stats.lib.pdx.edu/d2l.php?course_code=<?php print($course_code); ?>&role_name=<?php print($role_name); ?>&url=http://library.pdx.edu" style="">Visit the PSU Library Website</a></div>');
document.write('</center>');