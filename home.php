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
		<li><a href=""><i class="icon-user"></i> <?php echo $_GET["uname"]; ?></a>
			<ul>
				<li><a href=""><i class="icon-cog"></i> Settings</a></li>
				<li class="divider"></li>
				<li><a href="login.php?flag='deletecookie'"><i class="icon-remove-circle"></i> Sign Out</a></li>
			</ul>
		</li>
		<li class="divider"></li>
		<li class="current"><a href=""><i class="icon-home"></i> Home</a></li>
		<li><a href="movies.php"><i class="icon-facetime-video"></i> Movies</a></li>
		<li><a href="actors.php"><i class="icon-group"></i> Actors</a></li>
		<li><a href="users.php"><i class="icon-thumbs-up"></i> Users</a></li>
	</ul>

	<div class="grid">
		 
		<div class="col_12">
			<h3>Movies you want to see</h3>
			<div class="col_2">
				<h5>Argo</h5>
				<img title="Argo (2012)" src="/www/cs445_4_s13/imgs/argo.jpg" width="150" height="300" />
			</div>
		
			<div class="col_2">
				<h5>Life of Pi</h5>
				<img title="Life of Pi (2012)" src="/www/cs445_4_s13/imgs/life_of_pi.jpg" width="150" height="300" />
			</div>
			
			<div class="col_2">
				<h5>Zero Dark Thirty</h5>
				<img title="Zero Dark Thirty (2012)" src="/www/cs445_4_s13/imgs/zero_dark_thirty.jpg" width="150" height="300" />
			</div>

			<div class="col_2">
				<h5>The Dark Kni...</h5>
				<img title="The Dark Knight Rises (2012)" src="/www/cs445_4_s13/imgs/dark_knight_rises.jpg" wwidth="150" height="300" />
			</div>
			
			<hr />
			
			<h3>Top Movies</h3>

			<div class="col_3">
				<h5>Argo</h5>
				<img title="Argo (2012)" src="/www/cs445_4_s13/imgs/argo.jpg" width="457" height="678" />
				<p>A dramatization of the 1980 joint CIA-Canadian secret operation to extract six fugitive American diplomatic personnel out of revolutionary Iran.</p>
			</div>
			
			<div class="col_3">
				<h5>Life of Pi</h5>
				<img title="Life of Pi (2012)" src="/www/cs445_4_s13/imgs/life_of_pi.jpg" width="400" height="350" />
				<p>A young man who survives a disaster at sea is hurtled into an epic journey of adventure and discovery. While cast away, he forms an unexpected connection with another survivor: a fearsome Bengal tiger.</p>
			</div>
			
			<div class="col_3">
				<h5>Zero Dark Thirty</h5>
				<img title="Zero Dark Thirty (2012)" src="/www/cs445_4_s13/imgs/zero_dark_thirty.jpg" width="400" height="350" />
				<p>A chronicle of the decade-long hunt for al-Qaeda terrorist leader Osama bin Laden after the September 2001 attacks, and his death at the hands of the Navy S.E.A.L. Team 6 in May 2011.</p>
			</div>
			
			<div class="col_3">
				<h5>The Dark Knight Rises</h5>
				<img title="The Dark Knight Rises (2012)" src="/www/cs445_4_s13/imgs/dark_knight_rises.jpg" width="400" height="350" />
				<p>Eight years on, a new evil rises from where the Batman and Commissioner Gordon tried to bury it, causing the Batman to resurface and fight to protect Gotham City... the very city which brands him an enemy.</p>
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
</body>
</html>