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
	<link rel="stylesheet" type="text/css" href="/www/cs445_4_s13/bss2.css" media="all" />
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
		<li class="current"><a href="movies.php"><i class="icon-facetime-video"></i> Movies</a>
			<ul>
				<li><a href="popular.php"><i class="icon-comments"></i> Popular</a></li>
			</ul>
		</li>
		<li><?php echo '<a href="castmembers.php">' ?><i class="icon-group"></i> Cast Members</a></li>
		<li><?php echo '<a href="users.php">' ?><i class="icon-thumbs-up"></i> Users</a>
			<ul>
				<li><a href="yum.php"><i class="icon-food"></i> Good Taste</a></li>
			</ul>
		</li>
	</ul>

	<div class="grid">
		<div class="col_12">
			<form id="query" class="vertical" action="admin.php" method="GET">
				<div class="col_9">
					<!-- SQL Box -->
					<label for="sql_box">Type a query</label><br/>
					<textarea id="sql_box" name="sql_box" placeholder="Enter you own SQL query here"></textarea>
				</div>
			</form>
		</div>
		<div class="col_2">
			<button form="query" type="submit" class="blue"><i class="icon-bolt"></i> Execute</button>
		</div>
		<?php
		$host = "cs445sql";
		$user = "bstearns";
		$pass = "EL542bst";

		$databaseName = "bss";
	  	$con = mysql_connect($host,$user,$pass);
	  	$dbs = mysql_select_db($databaseName, $con);

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

	  	if(isset($_GET["sql_box"])){
	  		$query = $_GET["sql_box"];

	  		$starttime = microtime(true);
		  	$result = mysql_query($query);
		  	$endtime = microtime(true);

	  		$duration = round($endtime - $starttime, 2);

	  		$data = array();
			while ($row = mysql_fetch_assoc($result)){
		  		$data[] = $row;
			}
			echo "<hr />";
			echo "<h4>" . count($data) . " Results</h4>";
			echo "<h5>" . $duration . " Seconds</h5>";
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
						echo '<td>' . $value[$attr] . '</td>';
					}
				}
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";

		}
		?>
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