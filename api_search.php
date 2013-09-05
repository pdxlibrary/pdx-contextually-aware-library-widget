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


if(USE_CACHE)
{
	if(!strcmp(CACHE_TYPE,"database"))
	{
		require_once("includes/connect.php");
		require_once("includes/mysql_functions.php");
	}
}


function api_search($query_string)
{
	if(USE_CACHE)
	{
		if(!strcmp(CACHE_TYPE,"database"))
		{
			//print("<br>query: $query_string<br>\n");
			$select = "select * from cache where query_string like '".$query_string."' and date_added > '".CACHE_CUTOFF."' and active like '1' limit 1";
			//print("select: $select<br>\n");
			$res = mysql_query($select);
			if(mysql_num_rows($res)==1)
			{
				// use the cached version
				$results = mysql_fetch_object($res);
				print("document.write('<!-- from cache ".date("Y-m-d H:i:s",strtotime($results->date_added))." -->');");
				return($results->result);
			}
		}
		else if(!strcmp(CACHE_TYPE,"memcache"))
		{
			$memcache = @memcache_connect(CACHE_SERVER,CACHE_PORT);
			
			$result = array();
			$result = $memcache->get($query_string);
			if($result)
			{
				print("document.write('<!-- from cache -->');");
				return($result);
			}
		}
	}

	// if cache is off or no fresh cache version
	$result = utf8_encode(file_get_contents("http://api.libguides.com/api_search.php?$query_string"));
	
	if(USE_CACHE)
	{
		if(!strcmp(CACHE_TYPE,"database"))
		{
			// add to cache
			$fields = array("query_string","result","date_added");
			$values = array($query_string,$result,date('Y-m-d H:i:s',strtotime('now')));
			@insert('cache',$fields,$values);
		}
		else if(!strcmp(CACHE_TYPE,"memcache"))
		{
			@$memcache->set($query_string,$result,0,60*60*24);
		}
	}
	
	return($result);
}



?>