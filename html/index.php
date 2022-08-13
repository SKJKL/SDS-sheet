<!DOCTYPE html>
<html lang="de" class="page-<?=str_replace("/", "-", $subView)?>">
<head>
	<meta charset="utf-8">
	<title>MolData</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" type="text/css" href="master.css" media="screen">
	<!-- <script charset="utf-8" type="text/javascript" src="js/master.js"></script> -->
</head>
<body>
<div id="wrapper">
	<header>
		<div id="title">MolData Search</div>
		<ul>
			<li class="nav-home"><a href="/">Home</a></li>
			<li class="nav-kontakt"><a href="/kontakt">Another tab</a></li>
		</ul>
	</header>
	
	<div id="content">
		
<?php require("home.php") ?>
		
	</div>
	
	<footer>&copy; Footer</footer>
</div>
</body>
</html>