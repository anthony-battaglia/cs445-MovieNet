<?php
if(isset($_POST["email"])){
	if($_POST["email"] != "" && $_POST["password"] != "" && $_POST["uname"]){
		$host = "cs445sql";
		$user = "bstearns";
		$pass = "EL542bst";

		$databaseName = "bss";
		$con = mysql_connect($host,$user,$pass);
		$dbs = mysql_select_db($databaseName, $con);

		$emailcheckSQL = "SELECT email FROM Users WHERE email ='" . $_POST["email"] . "'";
		$result = mysql_query($emailcheckSQL);

		if(!$result){
			//ERROR with sql
		}
		if(mysql_num_rows($result) > 0){
			echo "This email address already exists";
		}
		else{
			$query = "INSERT INTO Users (email, uname, pword, age, gender, location) VALUES ('" . $_POST["email"] . "', '" . $_POST["uname"] . "', '" . $_POST["password"] . "', '" . $_POST["age"] . "', '" . $_POST["gender"] . "', '" . $_POST["location"] . "')";
		
			if(mysql_query($query)){
				$sql = "SELECT email, pword, uname FROM Users WHERE email='" . $_POST["email"] . "'";
  				$sqlresult = mysql_query($sql);
	  			if(!$sqlresult){
  				//TODO invalid email, pw message
	  			}
  				else{
  					if($row = mysql_fetch_array($sqlresult)){
  						$email = $row[0];
  						$password = $row[1];
  						if($password == $_POST["password"]){
	  						setcookie("email", $email, time()+3600);
  							$_COOKIE["email"] = $email;
  						}
  					}
  				}
			}
			else{
				
			}	
		}
	}
	else{
		echo "You must enter an email, username, and password"
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
		<form class="vertical" method="post" action="register.php">
			<label for="email">Email</label>
			<input id="email" name="email" type="text"/>

			<label for="password">Password</label>
			<input id="password" name="password" type="password"/>

			<label for="uname">Username <span>Limit 16 characters</span></label>
			<input id="uname" name="uname" type="text"/>

			<label for="age">Age</label>
			<input id="age" name="age" type="text"/>

			<label for="gender">Gender</label>
			<select id="gender" name="gender">
				<option value="">--</option>
				<option value="M">Male</option>
				<option value="F">Female</option>
				<option value="">Other</option>
			</select>

			<label for="location">Location</label>
			<input id="location" name="location" type="text"/>

			<input type="Submit" value="Register" /> 
		</form>
		<h6>Already have an account? <a href="login.php">Login here.</a>
	</div>
	<div style="display: none;" class="notice error"><i class="icon-remove-sign icon-large"></i> This is an Error Notice 
		<a href="#close" class="icon-remove"></a>
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