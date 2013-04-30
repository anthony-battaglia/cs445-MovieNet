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
		<?php
		$uname = $_GET["uname"];
		?>
		<li><a href=""><i class="icon-user"></i> <?php echo $uname; ?></a>
			<ul>
				<li><a href=""><i class="icon-cog"></i> Settings</a></li>
				<li class="divider"></li>
				<li><a href="login.php?flag='deletecookie'"><i class="icon-remove-circle"></i> Sign Out</a></li>
			</ul>
		</li>
		<li class="divider"></li>
		<li><?php echo '<a href="movies.php?uname='.urlencode($uname).'"' ?>><i class="icon-facetime-video"></i> Movies</a></li>
		<li class="current"><a href="castmembers.php"><i class="icon-group"></i> Cast Members</a></li>
		<li><?php echo '<a href="users.php?uname='.urlencode($uname).'"' ?>><i class="icon-thumbs-up"></i> Users</a></li>
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
		$pass = "EL807at";

		$databaseName = "bss";
	  	$con = mysql_connect($host,$user,$pass);
	  	$dbs = mysql_select_db($databaseName, $con);

	  	// $sql = "SELECT m.title, m.myear, m.runtime FROM Movies m";

	  	$select = array("m.title", "m.myear", "m.runtime, m.mpaa_rating");
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
	  		array_push($select, "a.aname", "c.role");
	  		array_push($from, "Actors a, Cast_Members c");
	  	}
	  	if(in_array("dname", $keys)){
	  		array_push($select, "ds.dname");
	  		array_push($from, "Directors ds", "Directed dd");
	  	}
	  	if(in_array("min_ratings", $keys)){
	  		array_push($select, "COUNT(r.rating)");
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
	  			array_push($where, 'r.title=m.title AND r.myear=m.myear GROUP BY r.title,r.myear HAVING COUNT(r.rating)>' . $_GET[$key]);
	  		}
	  	}
	  	if($keyCount > 0){
	  		$sql = build_sql($select, $from, $where);
	  		echo $sql;
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
					if(is_null($value[$attr])){
						echo "<td>--</td>";
					}
					else{
						echo "<td>" . $value[$attr] . "</td>";
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