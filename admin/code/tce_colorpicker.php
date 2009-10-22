<?php
//============================================================+
// File name   : tce_colorpicker.php
// Begin       : 2001-11-05
// Last Update : 2009-09-30
// 
// Description : HTML Color Picker Functions.
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com S.r.l.
//               Via della Pace, 11
//               09044 Quartucciu (CA)
//               ITALY
//               www.tecnick.com
//               info@tecnick.com
//
// License: 
//    Copyright (C) 2004-2009  Nicola Asuni - Tecnick.com S.r.l.
//    
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU Affero General Public License as
//    published by the Free Software Foundation, either version 3 of the
//    License, or (at your option) any later version.
//    
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU Affero General Public License for more details.
//    
//    You should have received a copy of the GNU Affero General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.
//     
//    Additionally, you can't remove the original TCExam logo, copyrights statements
//    and links to Tecnick.com and TCExam websites.
//    
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * HTML Color Picker Functions.
 * @package com.tecnick.tcexam.admin
 * @author Nicola Asuni
 * @copyright Copyright &copy; 2004-2009, Nicola Asuni - Tecnick.com S.r.l. - ITALY - www.tecnick.com - info@tecnick.com
 * @license http://www.fsf.org/licensing/licenses/agpl-3.0.html GNU Affero General Public License
 * @link www.tecnick.com
 * @since 2008-10-01
 */

/**
 */
 
require_once('../config/tce_config.php');
$pagelevel = 0;
//require_once('../../shared/code/tce_authorization.php');
$thispage_title = "Color Picker";
require_once('../code/tce_page_header_popup.php');
F_html_color_picker();
require_once('../code/tce_page_footer_popup.php');

/**
 * Display Color Picker
 * @author Nicola Asuni
 * @copyright Copyright &copy; 2004-2009, Nicola Asuni - Tecnick.com S.r.l. - ITALY - www.tecnick.com - info@tecnick.com
 * @license http://www.fsf.org/licensing/licenses/agpl-3.0.html GNU Affero General Public License
 * @link www.tecnick.com
 * @since 2008-10-01
 */
function F_html_color_picker() {
	global $l;
	require_once('../config/tce_config.php');
	require_once('../../shared/code/htmlcolors.php');
	require_once('../../shared/code/tce_functions_form.php');
	
	echo '<a onclick="FJ_pick_color(0); document.form_colorpicker.colorname.selectedIndex=0;"><img src="'.K_PATH_IMAGES.'buttons/colortable.jpg" alt="" name="colorboard" id="colorboard" width="320" height="300" hspace="0" vspace="0" border="0" /></a>'.K_NEWLINE;
	echo K_NEWLINE;
	echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" name="form_colorpicker" id="form_colorpicker">'.K_NEWLINE;	
	echo '<div class="smalldigit" style="width:320px;font-size:80%;" >';
	echo 'DEC:';
	echo '<input type="text" name="RED" id="RED" size="3" maxlength="3" readonly="readonly" title="RED (DEC)"/>';
	echo '<input type="text" name="GREEN" id="GREEN" size="3" maxlength="3" readonly="readonly" title="GREEN (DEC)"/>';
	echo '<input type="text" name="BLUE" id="BLUE" size="3" maxlength="3" readonly="readonly" title="BLUE (DEC)"/>';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;';
	echo 'HEX:';
	echo '<input type="text" name="HRED" id="HRED" size="3" maxlength="2" readonly="readonly" title="RED (HEX)"/>';
	echo '<input type="text" name="HGREEN" id="HGREEN" size="3" maxlength="2" readonly="readonly" title="GREEN (HEX)"/>';
	echo '<input type="text" name="HBLUE" id="HBLUE" size="3" maxlength="2" readonly="readonly" title="BLUE (HEX)"/>';
	echo '</div>'.K_NEWLINE;
	
	// print a table of websafe colors
	$ck = 1;
	echo '<div style="width:320px;">';
	while(list($key, $val) = each($webcolor)) { // for each color in table
		echo '<a title="'.$key.'" onclick="document.form_colorpicker.CSELECTED.value=\'#'.$val.'\';FJ_pick_color(1);document.form_colorpicker.colorname.selectedIndex='.$ck.';" style="text-decoration:none;font-size:3px;">';
		echo '<div style="background-color:#'.$val.';padding:0;margin:0;width:20px;height:10px;float:left;">&nbsp;</div>';
		echo '</a>';
		$ck++;
	}
	echo '</div>';
	echo '<br style="clear:both;"/>';
	echo '<div id="pickedcolor" style="visibility:visible;border:1px solid black;width:320px;height:30px;">&nbsp;</div>'.K_NEWLINE;
	echo '<select name="colorname" id="colorname" size="0" onchange="document.form_colorpicker.CSELECTED.value=document.form_colorpicker.colorname.options[document.form_colorpicker.colorname.selectedIndex].value; FJ_pick_color(1);">'.K_NEWLINE;
	echo '<option value=""></option>'.K_NEWLINE;
	reset($webcolor);
	while(list($key, $val) = each($webcolor)) { // for each color in table
		echo '<option value="#'.$val.'">'.$key.'</option>'.K_NEWLINE;
	}
	echo '</select>';
	echo '<input type="text" name="CSELECTED" id="CSELECTED" size="10" maxlength="7" value="" onchange="FJ_pick_color(1); document.form_colorpicker.colorname.selectedIndex=0;" />'.K_NEWLINE;
	$onclick = 'window.returnValue=document.form_colorpicker.CSELECTED.value;';
	echo '<input type="button" name="wclose" id="wclose" value="'.$l['w_close'].'" title="'.$l['h_close_window'].'" onclick="'.$onclick.'self.close();" />'.K_NEWLINE;
	echo '</form>'.K_NEWLINE;
?>
<script type="text/javascript">
//<![CDATA[
// variables
// ------------------------------------------------------------
var nnbrowser = window.Event ? true : false; //check netscape browser
var Xpos, Ypos;
var Red, Green, Blue;
var hexChars = '0123456789ABCDEF';

// ------------------------------------------------------------
// capture event
// ------------------------------------------------------------
if(nnbrowser) {// Netscape
	document.captureEvents(Event.MOUSEMOVE);
}
document.onmousemove = FJ_get_coordinates;

// ------------------------------------------------------------
// Get cursor coordinates and store on Xpos and Ypos variables
// ------------------------------------------------------------
function FJ_get_coordinates(e) {
  if(nnbrowser) { // Netscape
      Xpos = e.pageX;
      Ypos = e.pageY;
  } 
  else { // IE
      Xpos = (event.clientX + document.body.scrollLeft);
      Ypos = (event.clientY + document.body.scrollTop);
  }
  
  //calculate color
  if(Xpos<=50){
  	Red=255;
	Green=Math.round(Xpos * 5.1);
	Blue=0;
  }
  else if(Xpos<=100){
  	Red=255-Math.round((Xpos-50) * 5.1);
	Green=255;
	Blue=0;
  }
  else if(Xpos<=150){
  	Red=0;
	Green=255;
	Blue=Math.round((Xpos-100) * 5.1);
  }
  else if(Xpos<=200){
  	Red=0;
	Green=255-Math.round((Xpos-150) * 5.1);
	Blue=255;
  }
  else if(Xpos<=250){
  	Red=Math.round((Xpos-200) * 5.1);
	Green=0;
	Blue=255;
  }
  else if(Xpos<=300){
  	Red=255;
	Green=0;
	Blue=255-Math.round((Xpos-250) * 5.1);
  }
  else if(Xpos<=320){ //grey scale
	light = Math.round((1-(Ypos/300))*255);
	Red=light;
	Green=light;
	Blue=light;
  }
  
  // change luminosity
	if((Xpos>=0)&&(Xpos<=300)&&(Ypos>=0)&&(Ypos<=300)) {
		light = Math.round((1-(Ypos/150))*255);
		Red += light; 
		if(Red>255) {
			Red=255;
		} else if(Red<0) {
			Red=0;
		}
		Green += light;
		if(Green>255) {
			Green=255;
		} else if(Green<0) {
			Green=0;
		}
		Blue += light;
		if(Blue>255) {
			Blue=255;
		} else if(Blue<0) {
			Blue=0;
		}
	} 	
	// display color
	if((Xpos>=0)&&(Xpos<=320)&&(Ypos>=0)&&(Ypos<=300)) {
		document.form_colorpicker.RED.value = Red;
		document.form_colorpicker.GREEN.value = Green;
		document.form_colorpicker.BLUE.value = Blue;
	
		document.form_colorpicker.HRED.value = FJ_dec_to_hex(Red);
		document.form_colorpicker.HGREEN.value = FJ_dec_to_hex(Green);
		document.form_colorpicker.HBLUE.value = FJ_dec_to_hex(Blue);
	}
	return;
}

// ------------------------------------------------------------
// calculate color from coordinates
// manual=1 means color introduced by keyboard
// ------------------------------------------------------------
function FJ_pick_color(manual) {
	if((manual)||((Xpos<=320)&&(Ypos<=300))) { //check if coordinates are valid
		
		if(!manual) {
			document.form_colorpicker.CSELECTED.value = '#'+document.form_colorpicker.HRED.value+''+document.form_colorpicker.HGREEN.value+''+document.form_colorpicker.HBLUE.value;
		}
		
		newcolor = document.form_colorpicker.CSELECTED.value;
		
		//show selected color on picked color layer
		// check browser capabilities
		if(document.layers){                   
			document.layers['pickedcolor'].bgColor=newcolor;         
		}         
		if(document.all){      
			document.all.pickedcolor.style.backgroundColor=newcolor;  
		}        
		if(!document.all && document.getElementById){               
			document.getElementById('pickedcolor').style.backgroundColor=newcolor;           
		}
	}
	return;
}

// ------------------------------------------------------------
// convert decimal value to hexadecimal (FF is the max value)
// ------------------------------------------------------------
function FJ_dec_to_hex (Dec) {
	var a = Dec % 16; 
	var b = (Dec - a)/16; 
	hex = hexChars.charAt(b)+''+hexChars.charAt(a); 
	return hex; 
}

// default color
document.form_colorpicker.CSELECTED.value='#000000';
FJ_pick_color(1);
//]]>
</script>
<?php 
	return;
}
//============================================================+
// END OF FILE                                                 
//============================================================+
?>
