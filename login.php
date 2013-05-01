<?php
	if(isset($_GET["flag"])){
		setcookie("email", "", time()-3600);
		unset($_COOKIE["email"]);
	}
	if(isset($_POST["email"])){
		if($_POST["email"] != "" && $_POST["password"] != ""){
			$host = "cs445sql";
			$user = "bstearns";
			$pass = "EL542bst";

			$databaseName = "bss";
  			$con = mysql_connect($host,$user,$pass);
  			$dbs = mysql_select_db($databaseName, $con);

  			$query = "SELECT email, pword, uname FROM Users WHERE email='" . $_POST["email"] . "'";
  			$result = mysql_query($query);
  			if(!$result){
  			//TODO invalid email, pw message
	  		}
  			else{
  				if($row = mysql_fetch_array($result)){
  					$email = $row[0];
  					$password = $row[1];
  					$uname = $row[2];
  					if($password == $_POST["password"]){
	  					setcookie("email", $email, time()+3600);
  						$_COOKIE["email"] = $email;
  					}
  				}
  			}
		}
	}
	

  	if(isset($_COOKIE["email"])){
?>
<html>
<body>
<?php
  header('Location: movies.php');
	}
	else{
?>
<!DOCTYPE html>
<html>
<head>
	<title>MovieNet - bss</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content="CS445 Movie Database Class Project" />
	<link rel="stylesheet" type="text/css" href="/www/cs445_4_s13/css/kickstart.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/www/cs445_4_s13/css/style.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/www/cs445_4_s13/css/bss.css" media="all" />
</head>

<body>
	<div id="loginForm" class="col_4">
		<h3><strong>MovieNet</strong></h3>
		<form class="vertical" method="post" action="login.php">
			<input id="email" name="email" type="text" placeholder="Email" />
			<input id="password" name="password" type="password" placeholder="Password" />
			<input type="Submit" value="Submit" /> 
		</form>
		<h6>New to MovieNet? <a href="register.php">Register here.</a>
	</div>

	<div class="clear"></div>
	<div id="footer">
	&copy; UMass Amherst CS445 S13 Movie Database Class Project. This website was built with <a href="http://www.99lime.com">HTML KickStart</a>
	</div>

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="/www/cs445_4_s13/js/kickstart.js"></script>    
	<script type="text/javascript" src="/www/cs445_4_s13/js/bss.js"></script> 
</body>
</html>
<?php
	}
?>