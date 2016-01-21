<?php

set_time_limit(600);

require_once("includes/connect_eres.php");
require_once("includes/mysql_functions.php");

print("script start time: " . date("m/d/Y g:i:sa")."\n\n");

mysql_query("truncate table fall2014toprimo");


if (($handle = fopen("d2l_course_list.csv", "r")) !== FALSE)
{
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
	{
		$subject = utf8_encode($data[0]);
		$course_number = utf8_encode($data[1]);
		$section = utf8_encode($data[2]);
		
		if(!strcmp($subject,'Subject'))
			continue;

		$d2l_courses[$subject." ".$course_number][$section]["subject"] = utf8_encode($data[0]);
		$d2l_courses[$subject." ".$course_number][$section]["course_number"] = utf8_encode($data[1]);
		$d2l_courses[$subject." ".$course_number][$section]["section"] = utf8_encode($data[2]);
		$d2l_courses[$subject." ".$course_number][$section]["course_title"] = utf8_encode($data[3]);
		$d2l_courses[$subject." ".$course_number][$section]["instructor"] = utf8_encode($data[4]);
		$d2l_courses[$subject." ".$course_number][$section]["email"] = utf8_encode($data[5]);
		$d2l_courses[$subject." ".$course_number][$section]["crn"] = utf8_encode($data[6]);
		$d2l_courses[$subject." ".$course_number][$section]["crosslist"] = utf8_encode($data[7]);
		$d2l_courses[$subject." ".$course_number][$section]["d2l_id"] = utf8_encode($data[8]);
    }
    fclose($handle);
}

$user = "mikeflakus";
$pass = "Flakus1!";
$institution = "01ALLIANCE_PSU";
$user_api = 'AlmaSDK-' . $user . '-institutionCode-' . $institution;	// AlmaSDK-mikeflakus-institutionCode-01ALLIANCE_PSU


$soap_params = Array(
            'login'     => $user_api,
            'password'  => $pass,
            'trace'     => true,
            'exception' => true
        );



// header("Content-type: text/xml");

// course reserves
$starting_record = 1;
$per_request = 1;
$ending_record = $starting_record + $per_request - 1;

$client_reserves = new SoapClient("https://na01.alma.exlibrisgroup.com/almaws/CourseWebServices?wsdl", $soap_params);

$done = false;
$matches = 0;
$errors = 0;

while(!$done)
{
	try
	{
		// print("Loading $starting_record to $ending_record<br>\n");
		$params = array('arg0' => "",'arg1' => $starting_record,'arg2' => $per_request);
		$res = $client_reserves->searchCourseInformation($params);
	}
	catch (SoapFault $e)
	{
		print_r($e);
	} 

	//print($res->SearchResults);

	$results = simplexml_load_string($res->SearchResults);
	$attributes = $results->Attributes();
	// print_r($attributes);
	foreach($attributes as $var => $val)
	{
		if(!strcmp($var,'count'))
		{
			if($val == $per_request)
			{
				// print("there are more records to load...<br>\n");
				$starting_record += $per_request;
				$ending_record += $per_request;
			}
			else
			{
				print("finished loading...<br>\n");
				$done = true;
			}
			break;
		}
	}
	foreach($results as $result)
	{
		foreach($result->course as $course)
		{
			//print_r($course);
			
			// normalize values
			$pos = strpos($course->course_information->code,"/");
			if($pos === false)	$course_number = ((string)$course->course_information->code);
			else				$course_number = substr($course->course_information->code,0,$pos);
			print("course_number: ".((string)$course->course_information->code)." | $course_number\n");
			
			$pos = strpos($course->course_information->section,"/");
			if($pos === false)	$section = ((string)$course->course_information->section);
			else				$section = substr($course->course_information->section,0,$pos);
			print("section: ".((string)$course->course_information->section)." | $section\n");
			
			if(!strcmp(((string)$course->course_information->status),'INACTIVE'))
				continue;

			// check for matching d2l course
			
			if(isset($d2l_courses[$course_number][$section]))
			{
				// print("section found...\n");
				$primo_url = "http://alliance-primo.hosted.exlibrisgroup.com/primo_library/libweb/action/search.do?fn=search&ct=search&initialSearch=true&mode=Basic&tab=cr_tab&indx=1&dum=true&srt=rank&vid=PSU&frbg=&tb=t&vl%28freeText0%29=".urlencode($course_number." ".$section." ".$course->course_information->name)."&scp.scps=scope%3A%28PSU_CR%29";
				// print("URL: $primo_url");
				$d2l_course = $d2l_courses[$course_number][$section];
				
				print($course->course_information->code." | ");
				print($course->course_information->section." | ");
				print($course->course_information->name." | ");
				print($course->course_information->status." | ");
				print("$primo_url\n\n");
				
				// set cache
				// print_r($course);
				// print_r($d2l_course);
				$fields = array("d2l_id","primo_course_url","dept","number","section","instructor");
				$values = array($d2l_course["d2l_id"],$primo_url,$d2l_course["subject"],$d2l_course["course_number"],$d2l_course["section"],$d2l_course["instructor"]);
				$insert_result = insert("fall2014toprimo",$fields,$values);
				$matches++;
			}
			else if(isset($d2l_courses[$course_number]))
			{
				print(" ** ERROR: Course found in D2L, but no matching section: ".$course_number." ".$section."\n");
				print("available section options:\n");
				print_r($d2l_courses[$course_number]);
				$errors++;
			}
			else
			{
				print(" ** ERROR: Course not found in D2L list of courses: ".$course_number."\n");
				$errors++;
			}
		}
		//print("\n");
	}
	// print("script loop time: " . date("m/d/Y g:i:sa")."\n\n");
}

/*
foreach($d2l_courses as $subject => $course_numbers)
{
	foreach($course_numbers as $course_number => $sections)
	{
		foreach($sections as $section => $course)
		{
			print("$subject | $course_number | $section | ".json_encode($course)."\n");
		}
	}
}
*/

print("\n");
print("MATCHES: $matches\n");
print("ERRORS: $errors\n");

print("script end time: " . date("m/d/Y g:i:sa")."\n\n");

?>
