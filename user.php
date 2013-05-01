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
	<script src="/www/cs445_4_s13/bss2.js"></script>
	<style>img{border: 1px solid #8f8f8f;}</style>
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
		<?php
		if($uname == "admin@movienet.com"){
			$admin = '<li><a href="admin.php"><i class="icon-wrench"></i> Admin</a>';
			echo $admin;
		}
		?>
	</ul>

	<div class="grid">
		<div class="col_12">
			<div class="col_2">
			<?php
				$host = "cs445sql";
				$user = "bstaplet";
				$pass = "EL424bst";

				$databaseName = "bss";
			  	$con = mysql_connect($host,$user,$pass);
			  	$dbs = mysql_select_db($databaseName, $con);

			  	$email = $_GET["email"];
			  	$result = mysql_query('SELECT u.email AS email, u.uname AS uname, u.age AS age, u.gender AS gender, u.location AS location FROM Users u WHERE u.email="' . $email . '"');
			  	$data = array();
				while ($row = mysql_fetch_assoc($result)){
				  $data[] = $row;
				}
				$user = $data[0];

				$rresult = mysql_query('SELECT r.title as Title, r.myear as Year, r.rating as Rating FROM Rated r WHERE r.email="' . $email . '"');
				$ratings = array();
				while ($row = mysql_fetch_assoc($rresult)){
				  $ratings[] = $row;
				}

				$wresult = mysql_query('SELECT w.title AS Title, w.myear AS Year FROM Watch_Listed w WHERE w.email="' . $email . '"');
				$watchList = array();
				while ($row = mysql_fetch_assoc($wresult)){
				  $watchList[] = $row;
				}

				$fresult = mysql_query('SELECT f.title AS Title, f.myear AS Year FROM Favorites f WHERE f.email="' . $email . '"');
				$favorites = array();
				while ($row = mysql_fetch_assoc($fresult)){
				  $favorites[] = $row;
				}

				function init_table($row){
					echo "<table cellspacing='0' cellpadding='0'>";
					echo "<thead>";
					echo "<tr>";
					foreach ($row as $key => $value) {
						echo "<th>" . $key . "</th>";
					}
					echo "</tr>";
					echo "</thead>";
					echo "<tbody>";
	  			}
			  	$imgsrc = "/www/cs445_4_s13/imgs/profile_default.jpg";

				echo '<img src="' . $imgsrc . '" />'
			?>
			</div>
		
			<div class="col_7">
				<div class="notice success clearfix" style="background: #ffffff; color: #000000; border-color: #8f8f8f;">
					<h5><?php echo $user["uname"]; ?></h5>
					<p><?php echo $user["email"]; ?></p>
					<p><i><?php echo $user["age"] . "  |  " . $user["gender"] . "  |  " . $user["location"]; ?></i></p>
					<p>Rated: <strong><?php echo count($ratings); ?></strong>  Favorited: <strong><?php echo count($favorites); ?></strong>  Watch Listed <strong><?php echo count($watchList); ?></strong></p>
<!-- 					<p><i>Rated <strong><?php echo count($ratings); ?></strong> movies</i></p>
 -->				</div>
			</div>
		</div>
		<div class="col_6">
			<h5>Watch List</h5>
			<?php 
			if(isset($watchList[0])){
				init_table($watchList[0]);
				foreach($watchList as $movie){
					echo "<tr>";
					echo '<td><a href="movie.php?title=' . urlencode($movie["Title"]) . '&myear=' . $movie["Year"] . '">' . $movie["Title"] . "</td>";
					echo '<td>' . $movie["Year"] . "</td>";
					echo "</tr>";
				}
			}
			else echo "<i>No movies in Watch List</i>";
			?>
			</tbody>
			</table>
		</div>
		<div class="col_6">
			<h5>Favorites</h5>
			<?php 
			if(isset($favorites[0])){
				init_table($favorites[0]);
				foreach($favorites as $movie){
					echo "<tr>";
					echo '<td><a href="movie.php?title=' . urlencode($movie["Title"]) . '&myear=' . $movie["Year"] . '">' . $movie["Title"] . "</td>";
					echo '<td>' . $movie["Year"] . "</td>";
					echo "</tr>";
				}
			}
			else echo "<i>No movies in Favorites</i>";
			?>
			</tbody>
			</table>
		</div>
		<div class="col_7">
			<h5>Ratings</h5>
			<?php 
			if(isset($ratings[0])){
				init_table($ratings[0]);
				foreach($ratings as $rating){
					echo "<tr>";
					echo '<td><a href="movie.php?title=' . urlencode($rating["Title"]) . '&myear=' . $rating["Year"] . '">' . $rating["Title"] . "</td>";
					echo '<td>' . $rating["Year"] . "</td>";
					echo '<td>' . $rating["Rating"] . "</td>";
					echo "</tr>";
				}
			}
			else echo "<i>No movies rated</i>";
			?>
			</tbody>
			</table>
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