<?php
$host = "cs445sql";
$user = "bstaplet";
$pass = "EL424bst";

$databaseName = "bss";
$con = mysql_connect($host,$user,$pass);
$dbs = mysql_select_db($databaseName, $con);

if (!$_POST["title"] || !$_POST["myear"] || !$_POST["email"] || !$_POST["rating"]){
	header("Content-Type: application/json");
	header('HTTP/1.1 400 Bad Request', true, 400);
	echo "{ error: 'Missing/Invalid parameters' } ";
}

$sql = "INSERT INTO Rated VALUES ('" . $_POST["email"] . "', '" . $_POST["title"] . "', " . $_POST["myear"] . ", " . $_POST["rating"];
if ($_POST["review"]){
	$sql = $sql . ", '" . $_POST["review"] . "')";
} else {
	$sql = $sql . ", \\N)";
}
$response = mysql_query($sql);
header("HTTP/1.1 200 OK", true, 200);
header("Content-Type: application/json");
echo "{ query : \"" . $sql . "\", response : '" . $response . "' }";

mysql_close($con);
?>