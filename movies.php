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
		<div class="col_12">
			<h4>Search</h4>
			<form id="search" class="vertical" action="movies.php" method="GET">
				<div class="col_3">
					<input type="checkbox" id="prefix" name="prefix" />
					<label for="prefix" class="inline"><span>Starts With</span></label>
					<label for="title">Title <span>Ocean's Eleven</span></label>
					<input id="title" name="title" type="text" />
					<label for="myear">Year <span>2001</span></label>
					<input id="myear" name="myear" type="text" />
					<label for="mpaa_rating">MPAA Rating</label>
					<select id="mpaa_rating" name="mpaa_rating">
						<option value="">--</option>
						<option value="G">G</option>
						<option value="PG">PG</option>
						<option value="PG-13">PG-13</option>
						<option value="R">R</option>
						<option value="NC-17">NC-17</option>
					</select>
				</div>
				<div class="col_3">
					<label for="aname">Actor <span>Clooney, George</span></label>
					<input id="aname" name="aname" type="text" />
					<label for="dname">Director <span>Soderbergh, Steven</span></label>
					<input id="dname" name="dname" type="text" />
				</div>
				<div class="col_3">
					<label for="min_mratings">Minimum # of User Ratings <span>5000</span></label>
					<input id="min_mratings" name="min_ratings" type="text" />
				</div>
			</form>
		</div>
		<div class="col_2">
			<button form="search" type="submit" class="blue"><i class="icon-search"></i>Search</button>
		</div>
		<div style="display: none;" class="notice error"><i class="icon-remove-sign icon-large"></i> This is an Error Notice 
			<a href="#close" class="icon-remove"></a>
		</div>
		<?php
		$host = "cs445sql";
		$user = "atbattag";
		$pass = "EL807atb";

		$databaseName = "bss";
	  	$con = mysql_connect($host,$user,$pass);
	  	$dbs = mysql_select_db($databaseName, $con);

	  	// $sql = "SELECT m.title, m.myear, m.runtime FROM Movies m";

	  	$select = array("m.title as Title", "m.myear as Year", "m.runtime as Runtime, m.mpaa_rating as MPAA");
	  	$from = array("Movies m");
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
	  	if(in_array("aname", $keys)){
	  		array_push($select, "a.aname AS Actor", "c.role AS Role");
	  		array_push($from, "Actors a, Cast_Members c");
	  	}
	  	if(in_array("dname", $keys)){
	  		array_push($select, "ds.dname AS Director");
	  		array_push($from, "Directors ds", "Directed dd");
	  	}
	  	if(in_array("min_ratings", $keys)){
	  		array_push($select, "COUNT(r.rating) AS '# of Ratings'");
	  		array_push($from, "Rated r");
	  	}

	  	$keyCount = count($keys);
	  	
	  	foreach($keys as $key){
	  		if(strcmp($key, "title") == 0){
	  			if(in_array("prefix", $keys)){
	  				array_push($where, 'm.title LIKE "' . $_GET[$key] . '%"');
	  			}
	  			else array_push($where, 'm.title LIKE "%' . $_GET[$key] . '%"');
	  		}
	  		if(strcmp($key, "myear") == 0){
	  			array_push($where, "m.myear=" . $_GET[$key]);
	  		}
	  		if(strcmp($key, "mpaa_rating") == 0){
	  			array_push($where, 'm.mpaa_rating="' . $_GET[$key] . '"');
	  		}
	  		if(strcmp($key, "aname") == 0){
	  			array_push($where, 'c.title=m.title AND c.myear=m.myear AND c.aid=a.aid AND a.aname="' . $_GET[$key] . '"');
	  		}
	  		if(strcmp($key, "dname") == 0){
	  			array_push($where, 'dd.title=m.title AND dd.myear=m.myear AND dd.did=ds.did AND ds.dname="' . $_GET[$key] . '"');
	  		}
	  		if(strcmp($key, "min_ratings") == 0){
	  			if(is_numeric($_GET[$key])){
	  				array_push($where, 'r.title=m.title AND r.myear=m.myear GROUP BY r.title,r.myear HAVING COUNT(r.rating)>' . $_GET[$key]);
	  			}
	  		}
	  	}
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
						if(strcmp("Actor", $attr) == 0){
							echo '<td><a href="/php-wrapper/cs445_4_s13/actor.php?name=' . $value[$attr] . '">' . $value[$attr] . "</a></td>";
						}
						else if(strcmp("Director", $attr) == 0){
							echo '<td><a href="/php-wrapper/cs445_4_s13/director.php?name=' . $value[$attr] . '">' . $value[$attr] . "</a></td>";
						}
						else if(strcmp("Title", $attr) == 0){
							echo '<td><a href="/php-wrapper/cs445_4_s13/movie.php?title=' . $value[$attr] . '&myear=' . $value["Year"] . '">' . $value[$attr] . "</a></td>";
						}
						else echo '<td>' . $value[$attr] . '</td>';
					}
				}
				echo "</tr>";
 			}
			echo "</tbody>";
			echo "</table>";
		}
		?>
		<hr />
		<div class="col_12">
			<h4>Top 5 Rated</h4>
			<?php
	  			$result = mysql_query("SELECT R.title, R.myear, AVG(R.rating) AS avg_rating FROM Rated R GROUP BY R.title, R.myear HAVING COUNT(R.rating)>1000 ORDER BY avg_rating desc LIMIT 5");
	  			$top5 = array();
	  			$topMovies = array();
				while ($row = mysql_fetch_assoc($result)){
					$topMovies[] = $row;
			  		$top5[] = json_decode(file_get_contents("http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey=zmrwsazsgjur8vmd5qdafz8e&q=" . urlencode($row["title"]) . "&page_limit=1"), true);
				}
				foreach($topMovies as $key => $movie){
					$title = $movie["title"];
					$year = $movie["myear"];
					$avg = $movie["avg_rating"];
					$rmovie = json_decode(file_get_contents("http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey=zmrwsazsgjur8vmd5qdafz8e&q=" . urlencode($title) . "&page_limit=1"), true);
					$imgsrc = $rmovie["movies"][0]["posters"]["detailed"];
					echo '<div class="col_2">';
					echo '<a href="/php-wrapper/cs445_4_s13/movie.php?title=' . urlencode($title) . "&myear=" . $year .  '"> <img title="' . $title . '" src="' . $imgsrc . '" /></a>';
					echo '<small>' . $title . '</small><br>';
					echo '<label><span> ' . $year . '</span></label><br>';
					echo '<label><span> Avg. Rating: <strong>' . $avg . '</strong></span></label>';
					echo '</div>';
				}
	  		?>
						
			</div>
		</div>
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