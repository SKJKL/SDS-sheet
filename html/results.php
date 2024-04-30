<?php
// Save file
file_put_contents("sds.pdf", file_get_contents($_SESSION["sds"]));

// Parse file
include("../vendor/autoload.php");
$parser = new \Smalot\PdfParser\Parser();
$pdf = $parser->parseFile('sds.pdf');
// $text = $pdf->getPages()[0]->getText();
$raw = $pdf->getText();
$text = preg_replace("/.*Page[\s|\S]*?(?:Canada)/", "", $raw);
$text = preg_replace("/\n+\s*\n/", "\n", $text);

// Regexes
$rgx_hazards = "/Hazard Statement.*\n\KH(?:.*\n)*?(?=Precautionary Statements(?:.*\n)*?Reduced Labeling)/m";
$rgx_mw = "/Molecular weight\D*\K\d.*(?= g\/mol)/";
$rgx_cas = "/CAS-No\D*\K[\d-]*(?=\D)/";
$rgx_formula = "/Formula\W*\K[\w-]*(?=\W)/";
$rgx_fire = "/Suitable extinguishing media\W*\K(?:.*\s)*?(?=5\.3 Advice)/";
$rgx_props = "/Information on basic physical and chemical properties\W*\K(?:.*\s)*?(?=SECTION 10)/";
$rgx_name = "/Product name.*\n\K(?:.*\s)*?(?=Product)/";
$rgx_syn = "/Synonyms.*:\s\K[\S\s]*?(?=Formula)/";

$info_hazards = $info_mw = $info_cas = $info_formula = $info_fire = $info_props = $info_name = $info_syn = "";
$info_sds = $_SESSION["sds"];

// Matches
$rgx_info = array(
	'name'=>["Name", $rgx_name],
	'syn'=>["Synonyms", $rgx_syn],
	'formula'=>["Molecular Formula", $rgx_formula],
	'mw'=>["Molecular Weight", $rgx_mw],
	'cas'=>["CAS No.", $rgx_cas],
	'hazards'=>["Hazard Statements", $rgx_hazards],
	'fire'=>["Suitable Extinguishing Media", $rgx_fire],
	'props'=>["Physical and Chemical Properties", $rgx_props],
);
?>

<section id=key-info>
	<h3>Summary</h3>
	<br>
	<div class=key-grid>
		<div class="grid-div grid-name"></div>
		<div class="grid-div grid-syn"></div>
		<div class="grid-div grid-formula"></div>
		<div class="grid-div grid-mw"></div>
		<div class="grid-div grid-cas"></div>
		<div class="grid-div grid-hazards"></div>
		<div class="grid-div grid-fire"></div>
		<div class="grid-div grid-props"></div>
		<div class="grid-div grid-sds">
			<h4>SDS link</h4>
			<hr>
			<p><a href="<?= $info_sds ?>" target="_blank"><?php if ($info_sds) echo "SDS link"; ?></a></p>
		</div>
	</div>
</section>

<section id=results>
    <h3>Raw Results</h3>
	<br>
	<h4>SDS link</h4>
    <pre><?= $info_sds ?></pre>

<?php
foreach ($rgx_info as $key=>$values):
	preg_match($values[1], $text, $info);
	$raw_info = $info[0];
	if ($key == 'props') {
		$info[0] = preg_replace("/\n(?!([a-z]\)))/", "<b>$1</b>", $info[0]);
		$info[0] = preg_replace("/(?:^|\n)\K([a-z]\))/", "<b>$1</b>", $info[0]);
	}
	if ($key == 'formula') $info[0] = preg_replace("/([^\d])(\d)/", "$1<sub>$2</sub>", $info[0]);
	if ($key == 'mw') $info[0] = $info[0] . " g/mol";
	if ($key == 'fire') {
		$info[0] = preg_replace("/([\S\s]*)(?:Unsuitable extinguishing media\s*)([\S\s]*)(?:5\.2.*\s*)([\S\s]*)/", "<b>Suitable:</b> $1\n<b>Unsuitable:</b> $2\n<b>Special hazards:</b> $3", $info[0]);
		$info[0] = preg_replace("/\n\b/", "", $info[0]);
	}
?>
	<br>
	<h4><?= $values[0] ?></h4>
	<pre class="<?= $key ?>"><?= $raw_info ?></pre>
	<script>
		console.log(<?= json_encode($info[0]) ?>);
		var for_summary = <?= json_encode("<h4>" . $values[0] . "</h4><hr><p>" . $info[0] . "</p>") ?>;
		document.getElementsByClassName("grid-"+<?= json_encode($key) ?>)[0].innerHTML = for_summary;
	</script>
<?php endforeach; ?>
</section>
<section id=whole-text>
	<h3>Whole text</h3>
	<pre>
<?php
echo $raw;

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
	let sds = <?= json_encode($_SESSION["sds"], JSON_HEX_TAG) ?>;
	console.log(sds);
	// window.open(sds);
</script>