<?php

	$db = mysql_connect('localhost','root','');
	$select = mysql_select_db('realtime',$db); 
	mysql_set_charset ('utf-8');
		if (!$select){ 
			print mysql_error() . "<br>\n"; 
		} 
?>