<section id=results>
    <h3>Results</h3>
    <p><?= $_SESSION["sds"] ?></p>
<?php
// Save file
file_put_contents("sds.pdf", file_get_contents($_SESSION["sds"]));

// Parse file
include("../vendor/autoload.php");
$parser = new \Smalot\PdfParser\Parser();
$pdf = $parser->parseFile('sds.pdf');
// $text = $pdf->getPages()[0]->getText();
$raw = $pdf->getText();
$raw_no_space = preg_replace("/\n+\s*\n/", "\n", $raw);
$text = preg_replace("/Sigma-Aldrich.*Page.*\n.*\n(?:Canada)?\s*/", "", $raw_no_space);

// Regexes
$rgx_hazards = "/Hazard Statement.*\n\KH(?:.*\n)*?(?=Precautionary Statements(?:.*\n)*?Reduced Labeling)/m";
$rgx_mw = "/Molecular weight\D*\K\d.*(?= g\/mol)/";
$rgx_cas = "/CAS-No\D*\K[\d-]*(?=\D)/";
$rgx_formula = "/Formula\W*\K[\w-]*(?=\W)/";
$rgx_fire = "/Suitable extinguishing media\W*\K.*/";
$rgx_props = "/Information on basic physical and chemical properties\W*\K(?:.*\s)*?(?=SECTION 10)/";
$rgx_name = "/Product name.*\n\K(?:.*\s)*?(?=Product)/";
$rgx_syn = "/Synonyms.*\n\K(?:.*\s)*?(?=Formula)/";
$rgx_ = "//";

// Matches
$rgx_info = array(
	"Name"=>$rgx_name,
	"Synonyms"=>$rgx_syn,
	"Molecular Formula"=>$rgx_formula,
	"Molecular Weight"=>$rgx_mw,
	"CAS No."=>$rgx_cas,
	"Hazard Statements"=>$rgx_hazards,
	"Suitable Extinguishing Media"=>$rgx_fire,
	"Physical and Chemical Properties"=>$rgx_props,
);

foreach ($rgx_info as $key=>$rgx):
	preg_match($rgx, $text, $info);
?>
	<h4><?= $key ?></h4>
	<pre><?= $info[0] ?></pre>
<?php endforeach; ?>
	<pre>
	<h3>Whole text</h3>
<?php
echo $text;

// preg_match_all("/SECTION \d\d?.*(?=SECTION|$)/m", $text, $sections);
// preg_match_all("/SECTION \d\d?/", $text, $sections);
// $text_done = preg_replace("/SECTION \d\d?\K\b/", "</h3>", $text_h3);

// foreach ($sections[0] as $section) {
// 	echo "<p>" . $section . "</p><br>";
// }
// echo $text_done;
?>
	</pre>
</section>



<script>
	// Verify matches
	<?php /*
	// console.log(<?= json_encode($query, JSON_HEX_TAG) ?>);
	// console.log(<?= json_encode($match_code, JSON_HEX_TAG) ?>);
	// console.log(<?= json_encode($match_type, JSON_HEX_TAG) ?>);
	*/ ?>
	// Open in new tab
	let sds = <?= json_encode($_SESSION["sds"], JSON_HEX_TAG) ?> ;
	console.log(sds);
	// window.open(sds);
</script>