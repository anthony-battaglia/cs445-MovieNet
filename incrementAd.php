<?php
$host = "cs445sql";
$user = "bstaplet";
$pass = "EL424bst";

$databaseName = "bss";
$con = mysql_connect($host,$user,$pass);
$dbs = mysql_select_db($databaseName, $con);

if (!$_GET["ccnum"]){
	header('HTTP/1.1 400 Bad Request', true, 400);
	echo "Missing/Invalid parameters";
}

$query = mysql_query('UPDATE Advertisers A SET A.clicks=A.clicks+1 WHERE A.ccnum=' . $_GET["ccnum"]);

if (!$query){
	header('HTTP/1.1 Internal Server Error', true, 500);
	echo "Query failed";
} else {
	header('HTTP/1.1 OK', true, 200);
	echo $query;
}

?>