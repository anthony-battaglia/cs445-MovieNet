<?php
if (!isset($_COOKIE["email"])){
	header("Location: login.php");
}
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
	<!-- Menu Horizontal -->
	<ul class="menu">
		<?php
			$uname = $_COOKIE["email"];
		?>
		<li><a href=""><i class="icon-user"></i> <?php echo $uname; ?></a>
			<ul>
				<li><a href="login.php?flag='deletecookie'"><i class="icon-remove-circle"></i> Sign Out</a></li>
			</ul>
		</li>
		<li class="divider"></li>
		<li><a href="movies.php"><i class="icon-facetime-video"></i> Movies</a>
			<ul>
				<li><a href="popular.php"><i class="icon-comments"></i> Popular</a></li>
			</ul>
		</li>
		<li><?php echo '<a href="castmembers.php">' ?><i class="icon-group"></i> Cast Members</a></li>
		<li class="current"><?php echo '<a href="users.php">' ?><i class="icon-thumbs-up"></i> Users</a>
			<ul>
				<li><a href="yum.php"><i class="icon-food"></i> Good Taste</a></li>
			</ul>
		</li>
	</ul>

	<div class="grid">
		<div class="col_12">
			<h5>Search For Users</h5>
			<form id="users_search" class="vertical" action="users.php">
				<div class="col_3">
					<label for="uname">Name <span>Derrick Myers</span></label>
					<input id="uname" name="uname" type="text" />
					<label for="age">Age <span>36</span></label>
					<input id="age" name="age" type="text" />
					<label for="gender">Gender</label>
					<select id="gender" name="gender">
						<option value="">--</option>
						<option value="F">Female</option>
						<option value="M">Male</option>
					</select>
					<label for="location">Location <span>Vermont</span></label>
					<input id="location" name="location" type="text" />
					<label for="email">Email <span>dmyers607823@xyz.net</span></label>
					<input id="email" name="email" type="text" />
				</div>
			</form>
		</div>
		<div class="col_2">
			<button form="users_search" type="submit" class="blue"><i class="icon-search"></i>Search</button>
		</div>

		<?php
			$host = "cs445sql";
			$user = "atbattag";
			$pass = "EL807atb";

			$databaseName = "bss";
		  	$con = mysql_connect($host,$user,$pass);
		  	$dbs = mysql_select_db($databaseName, $con);

		  	$select = array("u.uname AS Name, u.age AS Age, u.email AS Email, u.gender AS Gender, u.location AS Location");
		  	$from = array("Users u");
		  	$where = array();

		  	function build_sql($select, $from, $where){
		  		$sql= "SELECT ";
		  		for($i = 0; $i < count($select); $i++){
		  			$sql .= $select[$i];
		  			if($i < count($select)-1) $sql .= ", ";
		  		}

		  		$sql .= " FROM ";
		  		for($i = 0; $i < count($from); $i++){
		  			$sql .= $from[$i];
		  			if($i < count($from)-1) $sql .= ", ";
		  		}

		  		$sql .= " WHERE ";
		  		for($i = 0; $i < count($where); $i++){
		  			$sql .= $where[$i];
		  			if($i < count($where)-1) $sql .= " AND ";
		  		}

		  		return $sql;
		  	}

		  	function init_table($row){
				echo "<table class='sortable striped' cellspacing='0' cellpadding='0'>";
				echo "<thead>";
				echo "<tr>";
				foreach ($row as $key => $value) {
					echo "<th>" . $key . "</th>";
				}
				echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
		  	}

		  	$keys = array_keys($_GET);
		  	
		  	foreach($keys as $key){
		  		if(strcmp($key, "uname") == 0){
		  			array_push($where, 'u.uname LIKE "%' . $_GET[$key] . '%"');
		  		}
		  		if(strcmp($key, "age") == 0){
		  			array_push($where, 'u.age=' . $_GET[$key]);
		  		}
		  		if(strcmp($key, "location") == 0){
		  			array_push($where, 'u.location LIKE "%' . $_GET[$key] . '%"');
		  		}
		  		if(strcmp($key, "email") == 0){
		  			array_push($where, 'u.email="' . $_GET[$key] . '"');
		  		}
		  		if(strcmp($key, "gender") == 0){
		  			array_push($where, 'u.gender="' . $_GET[$key] . '"');
		  		}
	  		}

	  		$keyCount = count($keys);

	  		if($keyCount > 0){
		  		$sql = build_sql($select, $from, $where);
		  		$result = mysql_query($sql);
			  	$data = array();
				while ($row = mysql_fetch_assoc($result)){
				  $data[] = $row;
				}
				echo "<hr />";
				echo "<h4>" . count($data) . " Results</h4>";
				if(isset($data[0])){
					init_table($data[0]);
				}
				foreach ($data as $key => $value) {
					$keys = array_keys($value);
					echo "<tr>";
					foreach($keys as $attr){
						if(strlen($value[$attr]) == 0){
							echo "<td>--</td>";
						}
						else{
							if(strcmp("Name", $attr) == 0){
								echo '<td><a href="user.php?email=' . $value["Email"] . '">' . $value[$attr] . "</a></td>";
							}
							else echo "<td>" . $value[$attr] . "</td>";
						}
					}
					echo "</tr>";
	 			}
			}
	  		?>
	  		</tbody>
			</table>
		
	</div><!-- END GRID -->

<!-- ===================================== START FOOTER ===================================== -->
	<div class="clear"></div>
	<div id="footer">
	&copy; UMass Amherst CS445 S13 Movie Database Class Project. This website was built with <a href="http://www.99lime.com">HTML KickStart</a>
	</div>

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="/www/cs445_4_s13/js/kickstart.js"></script>  
	<script type="text/javascript" src="/www/cs445_4_s13/js/bss.js"></script>  
</body>
</html>