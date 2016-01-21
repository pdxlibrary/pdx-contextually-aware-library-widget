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

<form method="GET" action="http://stats.lib.pdx.edu/search_history.php" class="ui-body-c ui-corner-all" style="min-width:190px" target="_blank" name="catalog_form" id="catalog_form">
	<input type="hidden" value="1" name="primo">
	<input type="hidden" value="1" name="d2l">
	<table style="width:100%">
		<tr>
			<td width="100%">
				<label for="search-basic" class="ui-hidden-accessible">Library Catalog Search:</label>
				<input type="search" placeholder="Library Catalog Search" name="search_string" id="search-basic" value="" />
			</td>
			<td width="50">
				<input type="image" src="https://library.pdx.edu/d2l/go.gif">
			</td>
		</tr>
	</table>
</form>

