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

?>

<script>
$( document ).ready(function() {
	$('#research_guides').bind('expand', function () {
		parent.alter_iframe_height(document.body.scrollHeight);
	}).bind('collapse', function () {
		parent.alter_iframe_height("210");
	});
});

</script>

<?php

// Parse the incoming course code from the LMS
$course_code_parts = explode("_",$course_code);
$course_code_subparts = explode("-",$course_code_parts[1]);

$xlist_course_code = "";
if(!strcmp($course_code_parts[1],'XLIST'))
{
	$xlist_course_code = strtolower($course_code_parts[1]."_".$course_code_parts[2]);
}

$lg_course_code = $course_code_subparts[0] . " " . $course_code_subparts[1];

$best_guide = "";

if(isset($course_code_subparts[0]) && strcmp($course_code_subparts[0],''))
{
	if(strcmp($xlist_course_code,''))
		$search = urlencode($xlist_course_code);
	else
		$search = urlencode($course_code_subparts[0] . " " . $course_code_subparts[1] . "-" . $course_code_subparts[2]);
		
	$course_guides_content = api_search($search);
	if(!strcmp(substr($course_guides_content,0,21),'No results were found'))
	{
		//print("2nd course search<br>\n");
		$search = urlencode($course_code_subparts[0] . " " . $course_code_subparts[1]);
		$course_guides_content = api_search($search);
	}
	
	if(strcmp(substr($course_guides_content,0,21),'No results were found'))
	{
		$lines = explode("\n",$course_guides_content);
		//print_r($lines);

		$subject_counter = 0;
		$guide_counter = 0;
		foreach($lines as $line)
		{
			$line = strip_tags($line,"<a><li>");
			if(!strcmp(substr(strtolower($line),0,4),"<li>"))
			{
				$line = str_replace("href=\"http://guides.library.pdx.edu","class=\"ui-link-inherit\" style=\"font-size: 12px;\" href=\"http://stats.lib.pdx.edu/d2l.php?course_code=$course_code&role_name=$role_name&url=http://guides.library.pdx.edu",$line);
				$exact_match = str_replace("'","`",trim(strip_tags($line,"<a>")));
				//$best_guide = "<a href=\"http://stats.lib.pdx.edu/d2l.php?course_code=$course_code&role_name=$role_name&url=".$exact_match."\" target=\"_blank\">Course Guide for ".str_replace("'","`",strip_tags($line))."</a>";
				$best_guide = str_replace('"_blank">','"_blank" title="Research Guide for '.strip_tags($exact_match).'"data-role="button" data-icon="arrow-r" data-iconpos="right">Research Guide for ',$exact_match);
			}
		}
	}
}

if(!strcmp($best_guide,''))
{
	// look for a matching (or multiple matching) subject guide(s)
	//print("alert('$course_code_subparts[0]');");
	if(isset($course_code_subparts[0]) && strcmp($course_code_subparts[0],''))
	{
		$guides_by_subject = api_search($course_code_subparts[0]);
		$lines = explode("\n",$guides_by_subject);
		//print_r($lines);

		$subject_counter = 0;
		$guide_counter = 0;
		foreach($lines as $line)
		{
			$line = strip_tags($line,"<a><li>");
			if(!strcmp(substr(strtolower($line),0,4),"<li>"))
			{
				$line = str_replace("href=\"http://guides.library.pdx.edu","class=\"ui-link-inherit\" style=\"font-size: 12px;\" href=\"http://stats.lib.pdx.edu/d2l.php?course_code=$course_code&role_name=$role_name&url=http://guides.library.pdx.edu",$line);
				$subject_guides[] = str_replace("'","`",trim(strip_tags($line,"<a><li>")));
				$best_guide = "subject_guides";
			}
		}
	}
}

// set a default guide if there is no better matching guide for the particular course code
if(!strcmp($best_guide,''))
{
	$best_guide = "<a title=\"Research Guides &amp; Tutorials\" data-role=\"button\" data-icon=\"arrow-r\" data-iconpos=\"right\" href=\"http://stats.lib.pdx.edu/d2l.php?course_code=$course_code&role_name=$role_name&url=http://guides.library.pdx.edu\");\" target=\"_blank\">Research Guides &amp; Tutorials</a>";
}
	
?>



<?php


if(!strcmp($best_guide,'subject_guides') && count($subject_guides)>0)
{

	if(count($subject_guides)==1)
	{
		/*
		print("document.write('<div id=\"mylistid\" class=\"mylist column-wrapper mylist column-wrapper-2\">'); \n");
		print("document.write('<ul class=\"research_guides_block\">'); \n");
		print("document.write('<li class=\"subject_link\" style=\"font-size:13px; text-align:center\">'); \n");
		print("document.write('".str_replace("\">","\">Research Guide for ",strip_tags($subject_guides[0],"<a>"))."'); \n");
		print("document.write('</li>'); \n");
		print("document.write('</ul>'); \n");
		print("document.write('</div>'); \n");
		*/
		/*
		print("document.write('<ul data-role=\"listview\" data-inset=\"true\" data-dividertheme=\"b\" class=\"ui-listview ui-listview-inset ui-corner-all ui-shadow\">'); \n");
		print("document.write('<li data-corners=\"false\" data-shadow=\"false\" data-iconshadow=\"true\" data-wrapperels=\"div\" data-icon=\"arrow-r\" data-iconpos=\"right\" data-theme=\"a\" class=\"ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-first-child ui-last-child ui-btn-up-a\">'); \n");
		print("document.write('<div class=\"ui-btn-inner ui-li\">'); \n");
		print("document.write('<div class=\"ui-btn-text\">".str_replace("\">","\">Research Guide for ",strip_tags($subject_guides[0],"<a>"))."</div>'); \n");
		print("document.write('<span class=\"ui-icon ui-icon-arrow-r ui-icon-shadow\">&nbsp;</span></div>'); \n");
		print("document.write('</li>'); \n");
		print("document.write('</ul>'); \n");
		print("document.write('<br />'); \n");
		*/
		print(str_replace("\">","\" title=\"Research Guide for ".strip_tags($subject_guides[0])."\" data-role=\"button\" data-icon=\"arrow-r\" data-iconpos=\"right\">Research Guide for ",strip_tags($subject_guides[0],"<a>")));
	}
	else
	{		
	
	/*
		print("document.write('<ul data-role=\"listview\" data-inset=\"true\" data-dividertheme=\"b\" class=\"ui-listview ui-listview-inset ui-corner-all ui-shadow\"> '); \n");
		print("document.write('		 <li data-role=\"list-divider\" role=\"heading\" class=\"ui-li-divider ui-bar-inherit ui-first-child\">Advanced Search</li> '); \n");
		print("document.write('		 <li class=\"ui-last-child\"><a href=\"#\" class=\"ui-btn ui-btn-icon-right ui-icon-carat-r\">Find a specific room</a></li> '); \n");
		print("document.write('   </ul>'); \n");
		

		print("document.write('<ul data-role=\"listview\" data-inset=\"true\" data-dividertheme=\"a\" class=\"ui-listview ui-listview-inset ui-corner-all ui-shadow\">');\n");		
		print("document.write('<li data-role=\"list-divider\" role=\"heading\" class=\"ui-li-divider ui-bar-inherit ui-first-child\">Advanced Search</li>');\n");

		*/
		
		print("<div id='research_guides' data-role='collapsible' data-theme='c' data-content-theme='c'>\n");
		print("<h2>Research Guides for $lg_course_code</h2>\n");
		print("<ul data-role='listview'>\n");
		foreach($subject_guides as $guide)
		{
			print("<li>".str_replace("\">","\" title=\"Research Guide for ".strip_tags($guide)."\">Research Guide for ",strip_tags($guide,"<a>"))."</li>\n");
		}
		print("</ul></div>");
	}
	
	
}
else
{
/*
print("document.write('<div id=\"mylistid\" class=\"mylist column-wrapper mylist column-wrapper-2\">'); \n");
print("document.write('<ul class=\"research_guides_block\">'); \n");
print("document.write('<li class=\"subject_link\" style=\"font-size:13px; text-align:center\">'); \n");
print("document.write('$best_guide'); \n");
print("document.write('</li>'); \n");
print("document.write('</ul>'); \n");
print("document.write('</div>'); \n");
*/

/*
print("document.write('<ul data-role=\"listview\" data-inset=\"true\" data-dividertheme=\"b\" class=\"ui-listview ui-listview-inset ui-corner-all ui-shadow\">'); \n");
print("document.write('<li data-corners=\"false\" data-shadow=\"false\" data-iconshadow=\"true\" data-wrapperels=\"div\" data-icon=\"arrow-r\" data-iconpos=\"right\" data-theme=\"a\" class=\"ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-first-child ui-last-child ui-btn-up-a\">'); \n");
print("document.write('<div class=\"ui-btn-inner ui-li\">'); \n");
print("document.write('<div class=\"ui-btn-text\">$best_guide</div>'); \n");
print("document.write('<span class=\"ui-icon ui-icon-arrow-r ui-icon-shadow\">&nbsp;</span></div>'); \n");
print("document.write('</li>'); \n");
print("document.write('</ul>'); \n");
print("document.write('<br />'); \n");
*/
print($best_guide);

}


?>