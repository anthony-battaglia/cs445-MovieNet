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
		<li class="current"><?php echo '<a href="castmembers.php">' ?><i class="icon-group"></i> Cast Members</a></li>
		<li><?php echo '<a href="users.php">' ?><i class="icon-thumbs-up"></i> Users</a>
			<ul>
				<li><a href="yum.php"><i class="icon-food"></i> Good Taste</a></li>
			</ul>
		</li>
	</ul>

	<div class="grid">
			<ul class="tabs left">
				<li><a href="#actor">Actor</a></li>
				<li><a href="#director">Director</a></li>
			</ul>

			<div id="actor" class="tab-content">
				<form id="actor_search" action="castmembers.php">
				<div class="col_12">
					<h5>Search for Actors</h5>
					<div class="col_2">
						<h6>Actor Info</h6>
						<label for="aname">Name <span>Clooney, George</span></label>
						<input id="aname" name="aname" type="text" />
						<label for="role">Role <span>Danny Ocean</span></label>
						<input id="role" name="role" type="text" />
					</div>
				</div>
				</form>
				<div class="col_2">
					<button form="actor_search" type="submit" class="blue"><i class="icon-search"></i>Search</button>
				</div>
			</div>
			<div id="director" class="tab-content">
				<form id="director_search">
				<div class="col_12">
					<h5>Search for Directors</h5>
					<div class="col_2">
						<h6>Director Info</h6>
						<label for="dname">Name <span>Soderbergh, Steven</span></label>
						<input id="dname" name="dname" type="text" />
					</div>
					<div class="col_2">
						<h6>Movie Info</h6>
						<label for="title">Title <span>Ocean's Eleven</span></label>
						<input id="title" name="title" type="text" />
						<label for="myear">Year <span>2001</span></label>
						<input id="myear" name="myear" type="text" />
					</div>
				</div>
				</form>
				<div class="col_2">
					<button form="director_search" type="submit" class="blue"><i class="icon-search"></i>Search</button>
				</div>
			</div>

			<?php
			$host = "cs445sql";
			$user = "atbattag";
			$pass = "EL807atb";

			$databaseName = "bss";
		  	$con = mysql_connect($host,$user,$pass);
		  	$dbs = mysql_select_db($databaseName, $con);

		  	$select = array();
		  	$from = array();
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
		  		array_push($select, 'a.aname AS "Actor Name');
		  		array_push($from, "Actors a");
		  	}
		  	if(in_array("role", $keys)){
		  		array_push($select, 'a.aname as "Actor Name", c.role AS Role, m.title AS Title, m.myear as Year');
		  		array_push($from, "Cast_Members c", "Movies m");
		  		if(!in_array("Actors a", $from)){
		  			array_push($from, "Actors a");
		  		}
		  	}
		  	if(in_array("dname", $keys)){
		  		array_push($select, 'ds.dname AS "Director Name"');
		  		array_push($from, "Directors ds");
		  	}
		  	if(in_array("title", $keys)){
		  		if(!in_array('ds.dname AS "Director Name"', $select)){
		  			array_push($select, 'ds.dname AS "Director Name"');
		  		}
		  		array_push($select, "dd.title AS Title");
		  		array_push($select, "dd.myear AS Year");
		  		array_push($from, "Directed dd");
		  		if(!in_array("Directors ds", $from)){
		  			array_push($from, "Directors ds");
		  		}
		  	}
		  	if(in_array("myear", $keys)){
		  		if(!in_array('ds.dname AS "Director Name"', $select)){
		  			array_push($select, "ds.dname AS Name");
		  		}
		  		if(!in_array("dd.title AS Title", $select)){
		  			array_push($select, "dd.title AS Title");
		  		}
		  		if(!in_array("dd.myear AS Year", $select)){
		  			array_push($select, "dd.myear AS Year");
		  		}
		  		if(!in_array("Directed dd", $from)){
		  			array_push($from, "Directed dd");
		  		}
		  		if(!in_array("Directors ds", $from)){
		  			array_push($from, "Directors ds");
		  		}
		  	}
		  	

		  	foreach($keys as $key){
		  		if(strcmp($key, "aname") == 0){
		  			array_push($where, 'a.aname LIKE "%' . $_GET[$key] . '%"');
		  		}
		  		if(strcmp($key, "role") == 0){
		  			array_push($where, 'a.aid=c.aid and c.title=m.title AND c.myear=m.myear AND c.role="' . $_GET[$key] . '"');
		  		}
		  		if(strcmp($key, "dname") == 0){
		  			array_push($where, 'ds.dname LIKE "%' . $_GET[$key] . '%"');
		  		}
		  		if(strcmp($key, "title") == 0){
		  			array_push($where, 'dd.did=ds.did AND dd.title LIKE "%' . $_GET[$key] . '%"');
		  		}
		  		if(strcmp($key, "myear") == 0){
		  			array_push($where, "dd.did=ds.did AND dd.myear=" . $_GET[$key]);
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
							if(strcmp("Actor Name", $attr) == 0){
								echo '<td><a href="/php-wrapper/cs445_4_s13/actor.php?name=' . $value[$attr] . '">' . $value[$attr] . "</a></td>";
							}
							else if(strcmp("Director Name", $attr) == 0){
								echo '<td><a href="/php-wrapper/cs445_4_s13/director.php?name=' . $value[$attr] . '">' . $value[$attr] . "</a></td>";
							}
							else if(strcmp("Title", $attr) == 0){
								echo '<td><a href="/php-wrapper/cs445_4_s13/movie.php?title=' . $value[$attr] . '&myear=' . $value["Year"] . '">' . $value[$attr] . "</a></td>";
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