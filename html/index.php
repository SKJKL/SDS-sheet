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
	<link rel="stylesheet" type="text/css" href="master.css" media="screen">
	<!-- Font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
	<!-- Color palette from image -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
</head>

<body>
<header>
	<h1><a href="/">MolData Search</a></h1>
	<nav>
		<ul>
			<li class="nav-home"><a href="/">Home</a></li>
			<li class="nav-php"><a href="/phpinfo.php">PHP info</a></li>
		</ul>
	</nav>
</header>

<div id="image-cont">
	<div id="welcome-box" class="banner-div">
		<h2>Welcome to MolData search</h2>
	</div>

	<img id="image" src="bannerimg.jpg" />
	
	<div id="search-box" class="banner-div">
		<p><b>Type a chemical in the search box to get its safety data sheet.</b></p>
		<p class="small-tip">E.g. glucose, benzene, ethyl acetate, doxorubicin hydrochloride</p>
	
		<form action="search.php">
			<input type="text" placeholder="Search..." name="molname" id=search />
			<!-- <input type="submit" id="submit" /> -->
			<button id="search-button">
				<svg id="search-icon" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.9 19.7">
					<g fill="none">
						<path stroke-linecap="square" d="M18.5 18.3l-5.4-5.4"/>
						<circle cx="8" cy="8" r="7"/>
					</g>
				</svg>
			</button>
		</form>
		
	</div>
</div>

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

<section id="color">
	<h3>Image colour palette</h3>
	<div id=color-cont></div>
</section>

<footer>&copy; Footer</footer>

<script>
	document.getElementById("search").focus();

	// Prevent form submission
    const form = document.querySelector('form');
	form.addEventListener("submit", function(event) {
		if (document.getElementById("search").value.trim() === '') {
			event.preventDefault();
			console.log("Text input is empty. Form submission prevented.");
		}
	});
	
	// Color palette
	const colorThief = new ColorThief();
	const img = document.getElementById("image");
	image.addEventListener('load', function() {
        let colorMain = colorThief.getColor(img);
		let colorPalette = colorThief.getPalette(img);

		console.log(colorMain);
		console.log(colorPalette);

		const rgbaMain = 'rgba('+colorMain[0]+','+colorMain[1]+','+colorMain[2]+', 1)';
		document.getElementById("image-cont").setAttribute("style", "background-color: "+rgbaMain);

		var colDivMain = document.createElement("div");
		colDivMain.setAttribute("style", "background-color: "+rgbaMain+"; height: 40px; width: 40px; display: block;");
		document.getElementById("color-cont").appendChild(colDivMain);

		colorPalette.forEach(pal => {
			var rgba = 'rgba('+pal[0]+','+pal[1]+','+pal[2]+', 1)';
			var colDiv = document.createElement("div");
			colDiv.setAttribute("style", "background-color: "+rgba+"; height: 40px; width: 40px; display: inline-block;");
			document.getElementById("color-cont").appendChild(colDiv);
		});
      });

</script>
</body>
</html>