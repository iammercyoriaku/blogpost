<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="styles/styles.css">
</head>

<body>
	<section>
		<div class="mast">
			<h1>T<span>SSB</span></h1>
			<nav>
				<ul class="clearfix">
					<li><a href="addpost.php" <?php Utils::curNav("addpost.php"); ?>>Add Posts</a></li>
					<li><a href="viewpost.php" <?php Utils::curNav("viewpost.php"); ?>>View Posts</a></li>
					<li><a href="addarchives.php" <?php Utils::curNav("addacchives.php"); ?>>Add Archives</a></li>
					<li><a href="viewarchives.php" <?php Utils::curNav("viewarchives.php"); ?>>View Archives</a></li>
					<li><a href="logout.php" <?php Utils::curNav("logout.php"); ?>>Logout</a></li>
				</ul>
			</nav>
		</div>
	</section>
