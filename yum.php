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
			<div class="col_8">
				<h4>Good Tasting Users</h4>
				<label><span>These prestigious users rated at least 2 of our Top 5 movies, and did not rate them lower than a 9! They sure know what they're talking about!</span></label>
				<?php
				$q8 = 'SELECT DISTINCT R1.email AS Email, u.uname AS Name, u.age AS Age, u.location AS Location FROM Users u, Rated R1, (SELECT R.title, R.myear, AVG(R.rating) AS avg_rating FROM Rated R GROUP BY R.title, R.myear HAVING COUNT(R.rating)>1000 ORDER BY avg_rating desc LIMIT 5) AS Best_Movies WHERE R1.title=Best_Movies.title AND R1.myear=Best_Movies.myear AND R1.rating>=9 AND R1.email=u.email GROUP BY R1.email HAVING COUNT(R1.rating)>=2';
				$result = mysql_query($q8);
			  	$data = array();
				while ($row = mysql_fetch_assoc($result)){
				  $data[] = $row;
				}
				init_table($data[0]);
				foreach ($data as $key => $value) {
					$keys = array_keys($value);
					echo "<tr>";
					foreach($keys as $attr){
						if(strcmp("Name", $attr) == 0){
							echo '<td><a href="user.php?email=' . $value["Email"] . '">' . $value[$attr] . "</a></td>";
						}
						else echo "<td>" . $value[$attr] . "</td>";
					}
				}
				?>
				</tbody>
				</table>
			</div>
		</div>
		<div class="col_12">
			<div class="col_8">
				<h4>How They Rate</h4>
				<label><span>Here's how they've rated our Top 10</span></label>
				<?php
				$q10 = 'SELECT R2.title AS Title, R2.myear AS Year, avg(R2.rating) AS "Average Rating" FROM Rated R2, (SELECT R1.email FROM Rated R1, (SELECT R.title, R.myear, AVG(R.rating) AS avg_rating FROM Rated R GROUP BY R.title, R.myear HAVING COUNT(R.rating)>=1000 ORDER BY avg_rating desc LIMIT 5) AS Best_Movies WHERE R1.title=Best_Movies.title AND R1.myear=Best_Movies.myear AND R1.rating>=9 GROUP BY R1.email HAVING COUNT(R1.rating)>=2) AS Top_Users WHERE Top_Users.email=R2.email GROUP BY R2.title, R2.myear HAVING COUNT(R2.rating) >= 2 ORDER BY "Average Rating" desc LIMIT 10';
				$result = mysql_query($q10);
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
							echo '<td><a href="/php-wrapper/cs445_4_s13/movie.php?title=' . $value[$attr] . '&myear=' . $value["Year"] . '">' . $value[$attr] . "</a></td>";
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