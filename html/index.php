<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>MolData</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<!-- <base href="html"> -->
	<link rel="stylesheet" type="text/css" href="master.css" media="screen">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
	<!-- <link rel="shortcut icon" href="favicon.ico" /> -->
	<!-- <script charset="utf-8" type="text/javascript" src="js/master.js"></script> -->
</head>

<body>
<header>
	<h1><a href="/">MolData Search</a></h1>
	<nav>
		<ul>
			<li class="nav-home"><a href="/">Home</a></li>
			<li class="nav-kontakt"><a href="/phpinfo.php">PHP info</a></li>
		</ul>
	</nav>
</header>

<section id=home>
	<h2>Welcome to MolData search</h2>
	<p>Type a chemical in the search box to get its safety data sheet.</p>
	<p class="small-tip">E.g. glucose, benzene, ethyl acetate, doxorubicin hydrochloride</p>

	<form action="search.php">
		<input type="text" placeholder="Search.." name="molname" id=search />
		<input type="submit" />
	</form>
</section>

<?php
if (isset($_GET["status"]) && $_GET["status"] == "success") {
	require("results.php");
} elseif (isset($_GET["status"]) && $_GET["status"] == "failed") {
?>
<section id=results>
	<h3>Not found</h3>
	<p>Couldn't find SDS sheet</p>
	<p class="small-tip"><?= $_SESSION["throw"] ?></p>
</section>
<?php } ?>

<footer>&copy; Footer</footer>

<script>
	document.getElementById("search").focus();
</script>
</body>
</html>