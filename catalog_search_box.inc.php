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

function submit_catalog_search()
{
	var submit_catalog_form = document.getElementById("catalog_form");
	submit_catalog_form.submit();
}

document.write('<div id="catalog_form_holder" style="text-align:center"></div>\n');

var parentElement = document.getElementById("catalog_form_holder");
parentElement.innerHTML = "";
 	
// Create a form
var myForm = document.createElement('FORM');
myForm.method = 'GET';
myForm.action = 'https://library.pdx.edu/index.php';
myForm.target = '_blank';
myForm.setAttribute('Name', 'catalog_form');
myForm.id = 'catalog_form';

var textField = document.createElement('INPUT');
textField.type = 'hidden';
textField.setAttribute('value', '1');
textField.setAttribute('Name', 'psw');
myForm.appendChild(textField);

var textField2 = document.createElement('INPUT');
textField2.type = 'hidden';
textField2.setAttribute('value', '1');
textField2.setAttribute('Name', 'd2l');
myForm.appendChild(textField2);

var textField3 = document.createElement('INPUT');
textField3.type = 'text';
textField3.setAttribute('value', '');
textField3.setAttribute('Name', 'search_string');
textField3.setAttribute('Style', 'width:75%');
textField3.setAttribute('Value', 'Find books & more...');
textField3.setAttribute('onfocus', 'if(this.value==\'Find books & more...\') this.value=\'\';');
textField3.setAttribute('onblur', 'if(this.value==\'\') this.value=\'Find books & more...\';');
myForm.appendChild(textField3);

var textField4 = document.createElement('INPUT');
textField4.type = 'submit';
textField4.setAttribute('value', 'Go');
textField4.setAttribute('onclick', 'submit_catalog_search()');
textField4.setAttribute('style', 'margin-left:3px');
myForm.appendChild(textField4);

// Place the form into the page
parentElement.appendChild(myForm);
