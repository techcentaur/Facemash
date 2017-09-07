<?php
include('mysql.php');
include('functions.php');
//if rating-update the database
if ($_GET['winner'] && $_GET['loser']){
	$_GET['winner']=mysql_real_escape_string($_GET['winner']);
	$_GET['loser']=mysql_real_escape_string($_GET['loser']);
	//Get the winner
	$result=mysql_query("SELECT * FROM images WHERE image_id=".$_GET['winner']."");
	$winner = mysql_fetch_object($result);
	//Get the loser
	$result=mysql_query("SELECT * FROM images WHERE image_id=".$_GET['loser']."");
	$loser = mysql_fetch_object($result);

	//Update the winner score in the database
	$winner_expected = expected($loser->score, $winner->score);
	$winner_new_score = win($winner->score, $winner_expected);
	mysql_query("UPDATE images SET score=".$winner_new_score.",wins=wins+1 WHERE image_id=".$_GET['winner']."");

	//Update the loser score in the database
	$loser_expected = expected($winner->score, $loser->score);
	$loser_new_score = win($loser->score, $loser_expected);
	mysql_query("UPDATE images SET score=".$loser_new_score.",losses=losses+1 WHERE image_id=".$_GET['loser']."");

	//Insert Battle on clicking in the battle table of database
	mysql_query("INSERT INTO battles SET winner=".$_GET['winner'].",loser=".$_GET['loser']." ");

	//back to the front page
	header('location: index.php');
}

?>