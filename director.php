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
		$uname = $_GET["uname"];
		?>
		<li><a href=""><i class="icon-user"></i> <?php echo $uname; ?></a>
			<ul>
				<li><a href=""><i class="icon-cog"></i> Settings</a></li>
				<li class="divider"></li>
				<li><a href=""><i class="icon-remove-circle"></i> Sign Out</a></li>
			</ul>
		</li>
		<li class="divider"></li>
		<li><?php echo '<a href="movies.php?uname='.urlencode($uname).'"' ?>><i class="icon-facetime-video"></i> Movies</a></li>
		<li><?php echo '<a href="castmembers.php?uname='.urlencode($uname).'"' ?>><i class="icon-group"></i> Cast Members</a></li>
		<li><?php echo '<a href="userss.php?uname='.urlencode($uname).'"' ?>><i class="icon-thumbs-up"></i> Users</a></li>
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

				  	$dname = $_GET["name"];
				  	$imgsrc = "/www/cs445_4_s13/imgs/poster_default.gif";

					echo '<img title="' . $dname . '" src="' . $imgsrc . '" />'
				?>
			</div>
			<div class="col_7">
				<div class="notice success clearfix" style="background: #ffffff; color: #000000; border-color: #8f8f8f;">
					<?php 
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
					$sql = 'SELECT m.title AS Title, m.myear AS Year, m.mpaa_rating AS MPAA, m.runtime AS Runtime FROM Movies m, Directed dd, Directors ds WHERE dd.title=m.title AND dd.myear=m.myear AND dd.did=ds.did AND ds.dname="' . urldecode($dname) . '"';
					$result = mysql_query($sql);
				  	$data = array();
					while ($row = mysql_fetch_assoc($result)){
					  $data[] = $row;
					}
					echo "<h4>" . $dname . "</h4>";
					echo "<p><i>Directed <strong>" . count($data) . "</strong> movies</i></p>"
					?>
					<!-- <span><strong>Director:</strong> <a href=""><?php echo $cast[0]["dname"] ?></a></span> -->
				</div>
			</div>
		</div>
		<div class="col_12">
			<div class="col_8">
					<?php 
					echo "<h4>" . count($data) . " Productions</h4>";
					if(isset($data[0])){
						init_table($data[0]);
					}
					?>
					<?php
						foreach($data as $movie){
							echo "<tr>";
							echo '<td><a href="movie.php?title=' . urlencode($movie["Title"]) . '&myear=' . $movie["Year"] . '">' . $movie["Title"] . "</a></td>";
							echo '<td>' . $movie["Year"] . "</td>";
							echo '<td>' . $movie["MPAA"] . "</td>";
							echo '<td>' . $movie["Runtime"] . "</td>";
							echo "</tr>";
						}
					?>
				</tbody>
				</table>
			</div>
			<hr />
			<div class="col_8">
					<?php
					$csql = 'SELECT DISTINCT a.aname as Name, dd.title AS Title, dd.myear AS Year FROM Directed dd, Directors ds, Cast_Members c, Actors a WHERE dd.did=ds.did AND c.title=dd.title AND c.myear=dd.myear AND c.aid=a.aid AND ds.dname="' . urldecode($dname) . '"';
					$result = mysql_query($csql);
				  	$cast = array();
					while ($row = mysql_fetch_assoc($result)){
					  $cast[] = $row;
					}
					if(isset($cast[0])){
						init_table($cast[0]);
					}
					echo '<h4>' . count($cast) . ' Cast Members appearing in at least one movie</h4>';
					foreach($cast as $actor){
						echo "<tr>";
						echo '<td><a href="actor.php?name=' . urlencode($actor["Name"]) . '">' . $actor["Name"] . "</a></td>";
						echo '<td><a href="movie.php?title=' . urlencode($actor["Title"]) . '&myear=' . $actor["Year"] . '">' . $actor["Title"] . "</a></td>";
						echo '<td>' . $actor["Year"] . "</td>";
						echo "</tr>";
					}
					?>
				</tbody>
				</table>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="/www/cs445_4_s13/js/kickstart.js"></script>    
	<script type="text/javascript" src="/www/cs445_4_s13/js/bss.js"></script> 
</body>
</html>