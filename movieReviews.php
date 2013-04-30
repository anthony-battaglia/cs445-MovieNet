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

				  	$title = $_GET["title"];
				  	$year = $_GET["myear"];
				  	$sql = 'SELECT a.aname AS aname, c.role AS role, m.myear AS myear, ds.dname as dname FROM Movies m, Cast_Members c, Actors a, Directors ds, Directed dd WHERE m.title=c.title AND m.myear=c.myear AND c.aid=a.aid AND ds.did=dd.did AND dd.title=m.title AND dd.myear=m.myear AND m.title="' . urldecode($title) . '"';
				  	$result = mysql_query($sql);

				  	$cast = array();
				  	while ($row = mysql_fetch_assoc($result)){
			  			$cast[] = $row;
					}

					$avg = mysql_fetch_assoc(mysql_query('SELECT COUNT(r.rating) as num_ratings, AVG(r.rating) AS avg FROM Movies m, Rated r WHERE r.title=m.title AND r.myear=m.myear AND m.title="' . urldecode($title) . '"'));
					$data = json_decode(file_get_contents("http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey=zmrwsazsgjur8vmd5qdafz8e&q=" . urlencode($title) . "&page_limit=1"), true);
					$theMovie;
					if($data["total"] == 0){
						$imgsrc = "/www/cs445_4_s13/imgs/poster_default.gif";
					}
					else{
						$movies = $data["movies"];
						for($i = 0; $i < count($movies); $i++){
							if($movies[$i]["year"] == $_GET["myear"]){
								$theMovie = $movies[$i];
								break;
							}
						}
						$imgsrc = (isset($theMovie)) ? $theMovie["posters"]["detailed"] : "/www/cs445_4_s13/imgs/poster_default.gif";
					}
					echo '<img title="' . $title . '" src="' . $imgsrc . '" />';

					$sql = 'SELECT u.uname AS uname, r.rating AS rating, r.review AS review FROM Users u, Rated r WHERE u.email = r.email AND r.title="' . urldecode($title) . '" AND r.myear="' . $year . '" AND r.review IS NOT NULL';
				  	$result = mysql_query($sql);

				  	$reviews = array();
				  	while ($row = mysql_fetch_assoc($result)){
			  			$reviews[] = $row;
					}
				?>
			</div>
			<div class="col_7">
				<div class="notice success clearfix" style="background: #ffffff; color: #000000; border-color: #8f8f8f;">
				<h4><?php echo $_GET["title"] . " (" . $_GET["myear"] . ")"  ?></h4>
				<em>Avg Rating: <strong><?php echo $avg["avg"] ?></strong> (<?php echo $avg["num_ratings"] ?>)  </em><a href=<?php echo "/php-wrapper/cs445_4_s13/ratings.php?title=" . urlencode($title) . "&myear=" . $_GET['myear'] ?>>Rate</a>
				<p>
					<em><?php echo (isset($theMovie)) ? $theMovie["critics_consensus"] : "No description found."; ?></em>
				</p>
				<span><strong>Director:</strong> <a href=""><?php echo $cast[0]["dname"] ?></a></span>
				<?php
				if(isset($theMovie)){
					echo "<h6><small><strong>Starring: </strong>";
					$topCast = $theMovie["abridged_cast"];
					for($i = 0; $i < count($topCast); $i++){
						echo $topCast[$i]["name"];
						if($i < count($topCast)-1) echo ", ";
					}
				}
					?></small></h6>
				</div>
				<a href=<?php echo "/php-wrapper/cs445_4_s13/movieReviews.php?title=" . urlencode($title) . "&myear=" . $_GET['myear'] ?>>View Reviews</a>
			</div>
			<div class="col_3">
				<?php
				if (isset($theMovie)){
					$ad = mysql_query('SELECT * FROM Advertises A WHERE A.title="' . urldecode($title) . '" and A.myear=' . $_GET["myear"] . ' order by RAND() limit 0,1');
					if ($ad){
						while ($row = mysql_fetch_assoc($ad)){
							$advertiser = $row;
			  				echo '<img src=' . $row["ad"] . ' onclick="adClicked(\'' . $row["link"] . '\', ' . $row["ccnum"] . ')" id="ad"/>';
			  			}
			  		}
				}
				?>
			</div>
		</div>
		<div class="col_12">
			<div class="col_8">
				<h5>Reviews</h5>
				<table cellspacing="0" cellpadding="0">
				<thead><tr>
					<th>User</th>
					<th>Rating</th>
					<th>Review</th>
				</tr></thead>
				<tbody>
					<?php 
						foreach($reviews as $review){
							echo "<tr>";
							echo '<td><a href="">' . $review["uname"] . "</a></td>";
							echo '<td>' . $review["rating"] . '</td>';
							echo "<td>" . $review["review"] . "</td>";
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