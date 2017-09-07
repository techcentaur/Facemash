<?php
/*
 Facemash Script: 
 * Performance rating = [(Total of opponents' ratings + 400 * (Wins - Losses)) / score].
 */
include('mysql.php');
include('functions.php');
 
// Get random 2 images from the database
$query="SELECT * FROM images ORDER BY RAND() LIMIT 0,2";
$result = mysql_query($query);
while($row = mysql_fetch_object($result)) {
 $images[] = (object) $row;
}

// Get the top 10
$result = mysql_query("SELECT *, ROUND(score/(1+(losses/wins))) AS performance FROM images ORDER BY ROUND(score/(1+(losses/wins))) DESC LIMIT 0,10");
while($row = mysql_fetch_object($result)) {
  $top_ratings[] = (object) $row;
}

// Close the connection
mysql_close();
 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<title>Facemash</title>
<style type="text/css">
body, html {font-family: 'Nunito';width:100%;margin:0;padding:0;text-align:center;}
h1 {background-color:rgb(9, 97, 226);box-shadow: 3px 3px 3px #071f42; color:#fff;padding:20px 0;margin:0;}
a img {border:0;}
td {font-size:15px;text-align: center;}
.image {background-color:#eee;border:1px solid #ddd;border-bottom:1px solid #bbb;padding:5px;}
</style>
</head>
<body>
 
<h1>FaceMash</h1>
<h2>Were we let in for our looks? No. Will we be judged on them? Yes.</h2>
<h2>Who's hotter? Click to choose.</h2>
<center>
<table>
 <tr>
  <td valign="top" class="image"><a href="rate.php?winner=<?php echo $images[0]->image_id; ?>&loser=<?php echo $images[1]->image_id; ?>"><img src="images/<?php echo $images[0]->filename; ?>" height="250" width="250"/></a></td>
  <td valign="top" class="image"><a href="rate.php?winner=<?php echo $images[1]->image_id; ?>&loser=<?php echo $images[0]->image_id; ?>"><img src="images/<?php echo $images[1]->filename; ?>" height="250" width="250"/></a></td>
 </tr>
 <tr>
  <td><b>Won: </b><?php echo $images[0]->wins; ?>, <b>Lost: </b><?php echo $images[0]->losses; ?></td>
  <td><b>Won: </b><?php echo $images[1]->wins; ?>, <b>Lost: </b><?php echo $images[1]->losses; ?></td>
 </tr>
 <!--
 <tr>
  <td>Score: <?php echo $images[0]->score; ?></td>
  <td>Score: <?php echo $images[1]->score; ?></td>
 </tr>-->
 <tr>
  <td><b>Expected: </b><?php echo round(expected($images[1]->score, $images[0]->score), 4); ?></td>
  <td><b>Expected: </b><?php echo round(expected($images[0]->score, $images[1]->score), 4); ?></td>
 </tr>
</table>
</center>
<h2>Top Rated</h2>
<center>
<table>
 <tr>
  <?php foreach($top_ratings as $key => $image) {
   ?>
  <td valign="top"><img src="images/<?php echo $image->filename; ?>" width="70" /></td>
  <?php } ?>
 </tr>
 <?php /* Remove this to see the scoring
 <tr>
  <?php foreach($top_ratings as $key => $image) : ?>
  <td valign="top">Score: <?php echo $image->score; ?></td>
  <?php endforeach ?>
 </tr>
 <tr>
  <?php foreach($top_ratings as $key => $image) : ?>
  <td valign="top">Performance: <?php echo $image->performance;?></td>
  <?php endforeach ?>
 </tr>
 <tr>
  <?php foreach($top_ratings as $key => $image) : ?>
  <td valign="top">Won: <?php echo $image->wins; ?></td>
  <?php endforeach ?>
 </tr>
 <tr>
  <?php foreach($top_ratings as $key => $image) : ?>
  <td valign="top">Lost: <?php echo $image->losses; ?></td>
  <?php endforeach ?>
 </tr>
 */ ?>
</table>
</center>
</body>
</html>