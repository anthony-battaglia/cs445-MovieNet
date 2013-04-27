<!DOCTYPE html>
<html>
<head>
	<title>MovieNet - bss</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content="CS445 Movie Database Class Project" />
	<link rel="stylesheet" type="text/css" href="/www/cs445_4_s13/css/kickstart.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/www/cs445_4_s13/css/style.css" media="all" />
</head>

<body>
	<!-- Menu Horizontal -->
	<ul class="menu">
		<li><a href=""><i class="icon-user"></i> AnthonyB</a>
			<ul>
				<li><a href=""><i class="icon-cog"></i> Settings</a></li>
				<li class="divider"></li>
				<li><a href=""><i class="icon-remove-circle"></i> Sign Out</a></li>
			</ul>
		</li>
		<li class="divider"></li>
		<li><a href="home.php"><i class="icon-home"></i> Home</a></li>
		<li class="current"><a href=""><i class="icon-facetime-video"></i> Movies</a></li>
		<li><a href="actors.php"><i class="icon-group"></i> Actors</a></li>
		<li><a href="users.php"><i class="icon-thumbs-up"></i> Users</a></li>
	</ul>

	<div class="grid">
		<!-- <div class="col_12">
			<h6>Most Popular</h6>
			<div class="col_1">
				<img title="Argo (2012)" src="/www/cs445_4_s13/imgs/argo.jpg" width="150" height="300" />
			</div>
		
			<div class="col_1">
				<img title="Life of Pi (2012)" src="/www/cs445_4_s13/imgs/life_of_pi.jpg" width="150" height="300" />
			</div>
			
			<div class="col_1">
				<img title="Zero Dark Thirty (2012)" src="/www/cs445_4_s13/imgs/zero_dark_thirty.jpg" width="150" height="300" />
			</div>

			<div class="col_1">
				<img title="The Dark Knight Rises (2012)" src="/www/cs445_4_s13/imgs/dark_knight_rises.jpg" wwidth="150" height="300" />
			</div>
			<div class="col_1">
				<img title="Argo (2012)" src="/www/cs445_4_s13/imgs/argo.jpg" width="150" height="300" />
			</div>
		
			<div class="col_1">
				<img title="Life of Pi (2012)" src="/www/cs445_4_s13/imgs/life_of_pi.jpg" width="150" height="300" />
			</div>
			
			<div class="col_1">
				<img title="Zero Dark Thirty (2012)" src="/www/cs445_4_s13/imgs/zero_dark_thirty.jpg" width="150" height="300" />
			</div>

			<div class="col_1">
				<img title="The Dark Knight Rises (2012)" src="/www/cs445_4_s13/imgs/dark_knight_rises.jpg" wwidth="150" height="300" />
			</div>
			<div class="col_1">
				<img title="Argo (2012)" src="/www/cs445_4_s13/imgs/argo.jpg" width="150" height="300" />
			</div>
		
			<div class="col_1">
				<img title="Life of Pi (2012)" src="/www/cs445_4_s13/imgs/life_of_pi.jpg" width="150" height="300" />
			</div>
			
			<div class="col_1">
				<img title="Zero Dark Thirty (2012)" src="/www/cs445_4_s13/imgs/zero_dark_thirty.jpg" width="150" height="300" />
			</div>

			<div class="col_1">
				<img title="The Dark Knight Rises (2012)" src="/www/cs445_4_s13/imgs/dark_knight_rises.jpg" wwidth="150" height="300" />
			</div>

			<hr />

		</div> -->
		<div class="col_12">
			<h4>Search</h4>
			<form id="search" class="vertical" action="movies.php" method="GET">
				<div class="col_3">
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
					<label for="avg_rating">Average User Rating <span></span></label>
					<select id="avg_rating" name="avg_rating">
						<option value="">--</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
					</select>
				</div>
			</form>
		</div>
		<div class="col_2">
			<button form="search" type="submit" class="blue"><i class="icon-search"></i>Search</button>
		</div>
		<?php
		$host = "cs445sql";
		$user = "atbattag";
		$pass = "insert-edlab-password";

		$databaseName = "bss";
	  	$con = mysql_connect($host,$user,$pass);
	  	$dbs = mysql_select_db($databaseName, $con);

	  	$sql = "SELECT m.title, m.myear, m.runtime from Movies m";

	  	$keys = array_keys($_GET);
	  	if(in_array("aname", $keys)){
	  		$sql .= ", Actors a, Cast_Members c";
	  	}
	  	if(in_array("dname", $keys)){
	  		$sql .= ", Directed dd, Directors ds";
	  	}
	  	if(in_array("min_ratings", $keys)){
	  		$sql .= ", Rated r";
	  	}

	  	$keysLeft = count($keys);
	  	if($keysLeft > 0){
	  		$sql .= " WHERE";
	  	}
	  	
	  	foreach($keys as $key){
	  		if(strcmp($key, "title") == 0){
	  			$sql .= ' m.title LIKE "%' . $_GET[$key] . '%"';
	  		}
	  		if(strcmp($key, "myear") == 0){
	  			$sql .= ' m.myear=' . $_GET[$key];
	  		}
	  		if(strcmp($key, "mpaa_rating") == 0){
	  			$sql .= ' m.mpaa_rating="' . $_GET[$key] . '"';
	  		}
	  		if(strcmp($key, "aname") == 0){
	  			$sql .= ' c.title=m.title AND c.myear=m.myear AND c.aid=a.aid AND a.aname="' . $_GET[$key] . '"';
	  		}
	  		if(strcmp($key, "dname") == 0){
	  			$sql .= ' dd.title=m.title AND dd.myear=m.myear AND dd.did=ds.did AND ds.dname="' . $_GET[$key] . '"';
	  		}
	  		if(strcmp($key, "min_ratings") == 0){
	  			$sql .= ' r.title=m.title AND r.myear=m.myear GROUP BY r.title,r.myear HAVING COUNT(r.rating)>' . $_GET[$key];
	  		}
	  		$keysLeft--;
	  		if($keysLeft > 0){
	  			$sql .= ' AND';
	  		}
	  	}
	  	// echo $sql;
	  	if(count($keys) > 0){
	  		$result = mysql_query($sql);
		  	$data = array();
			while ($row = mysql_fetch_assoc($result)){
			  $data[] = $row;
			}
			echo "<hr />";
			echo "<table class='sortable' cellspacing='0' cellpadding='0'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Title</th>";
					echo "<th>Year</th>";
					echo "<th>Runtime (mins)</th>";
				echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			foreach ($data as $key => $value) {
 				echo "<tr>";
					echo "<td>" . $value["title"] . "</td>";
					echo "<td>" . $value["myear"] . "</td>";
					echo "<td>" . ($value["runtime"] ? $value["runtime"] : "--") . "</td>";
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