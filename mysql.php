<?php
$user="root";
$password="";
$database="facemashTechcentaur";
$host="localhost";
mysql_connect($host,$user,$password);
mysql_select_db($database) or die("unable to select database");
?>