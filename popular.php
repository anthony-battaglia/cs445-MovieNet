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
		<?php
		if($uname == "admin@movienet.com"){
			$admin = '<li><a href="admin.php"><i class="icon-wrench"></i> Admin</a>';
			echo $admin;
		}
		?>
	</ul>

	<div class="grid">
		<?php
		$host = "cs445sql";
		$user = "atbattag";
		$pass = "EL807atb";

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
	  	?>
		<div class="col_12">
			<div class="col_4">
				<h4># Ratings By Value</h4>
				<?php
				$q4 = 'SELECT r.rating as Rating, COUNT(*) as "# of Ratings" FROM Rated r GROUP BY r.rating';
				$result = mysql_query($q4);
			  	$data = array();
				while ($row = mysql_fetch_assoc($result)){
				  $data[] = $row;
				}
				init_table($data[0]);
				foreach ($data as $key => $value) {
					$keys = array_keys($value);
					echo "<tr>";
					foreach($keys as $attr){
						echo "<td>" . $value[$attr] . "</td>";
	 				}
	 				echo "</tr>";
				}
				?>
				</tbody>
				</table>
			</div>
			<div class="col_6">
				<h4>Over 5000 Ratings</h4>
				<?php
				$q6 = 'SELECT r.title AS Title, r.myear AS Year, AVG(u.age) AS "Average Age" FROM Users u, (SELECT * FROM Rated r GROUP BY r.title,r.myear HAVING COUNT(r.rating)>5000) AS r WHERE r.email=u.email GROUP BY r.title,r.myear';
				$result = mysql_query($q6);
			  	$data = array();
				while ($row = mysql_fetch_assoc($result)){
				  $data[] = $row;
				}
				init_table($data[0]);
				foreach ($data as $key => $value) {
					$keys = array_keys($value);
					echo "<tr>";
					foreach($keys as $attr){
						if(strcmp("Title", $attr) == 0){
							echo '<td><a href="/php-wrapper/cs445_4_s13/movie.php?title=' . urlencode($value[$attr]) . '&myear=' . $value["Year"] . '">' . $value[$attr] . "</a></td>";
						}
						else echo "<td>" . $value[$attr] . "</td>";
	 				}
	 				echo "</tr>";
				}
				?>
				</tbody>
				</table>
			</div>
		</div>
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