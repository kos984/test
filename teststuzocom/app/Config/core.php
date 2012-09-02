<?php


	$baze = mysql_connect("localhost","root","kos");
	if (!$baze){
		throw new Exception("Could not conect to basedate!");
	} 
	mysql_set_charset('utf8');
	if(!mysql_select_db("stuzo"))
		throw new Exception("Can't select baze...");
		
?>