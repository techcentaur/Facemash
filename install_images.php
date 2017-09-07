<?php
include('mysql.php');
if ($handle = opendir('images')){
	//correct way to open a directory
	while(false!== ($file = readdir($handle))){
		if ($file!='.' && $file!='..'){
			$images[]="('".$file."')";
		}
	}
	closedir($handle);
}

$query = ("INSERT into images (filename) VALUES ".implode(',', $images)." ");
if(!mysql_query($query)){
	print mysql_error();
}else{
	print "finsihed installing your images";
}

?>