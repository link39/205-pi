<?php

$username="root";
$password="bananapi";
$database="bdc";

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("arrives");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server
if(isset($_GET['id'])){
	$connection=mysql_connect ('localhost', $username, $password);
	if (!$connection) {  die('Not connected : ' . mysql_error());}

	// Set the active MySQL database

	$db_selected = mysql_select_db($database, $connection);
	if (!$db_selected) {
	  die ('Can\'t use db : ' . mysql_error());
	}

	// Select all the rows in the markers table

	$query = 'SELECT DATE_ADD(date,INTERVAL 2 HOUR) AS date,latitude, longitude FROM `kilometre` WHERE id_trajet='.$_GET['id'].' order by id desc limit 1';

	$result = mysql_query($query);
	if (!$result) {
	  die('Invalid query: ' . mysql_error());
	}

	header("Content-type: text/xml");

	// Iterate through the rows, adding XML nodes for each

	while ($row = @mysql_fetch_assoc($result)){
	  // ADD TO XML DOCUMENT NODE
	  $node = $dom->createElement("arrive");
	  $newnode = $parnode->appendChild($node);
	  $newnode->setAttribute("name","arrive");
	  $newnode->setAttribute("lat", $row['latitude']);
	  $newnode->setAttribute("lng", $row['longitude']);
	  $newnode->setAttribute("date", $row['date']);
	}

	echo $dom->saveXML();
}
?>

