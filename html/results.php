<?php
// Save file
// try {
// 	file_put_contents("sds.pdf", file_get_contents($_SESSION["sds"]));
// } catch (\Throwable $th) {
// 	header("Location: /" . "/CodeThings/MolData/html" . "/?status=failed");
// }

// Parse file
include("../vendor/autoload.php");
$parser = new \Smalot\PdfParser\Parser();
$pdf = $parser->parseFile('sds.pdf');
// $text = $pdf->getPages()[0]->getText();
$raw = $pdf->getText();
$text = preg_replace("/.*Page[\s|\S]*?(?:Canada)/", "", $raw);
$text = preg_replace("/\n+\s*\n/", "\n", $text);

// Regexes
$rgx_hazards = "/\n\bHazard.*?\n\K[\s\S]*?(?=Precau)/";
$rgx_mw = "/Molecular weight\D*\K\d.*(?= g\/mol)/";
$rgx_cas = "/CAS-No\D*\K[\d-]*(?=\D)/";
$rgx_formula = "/Formula\W*\K[\w-]*(?=\W)/";
$rgx_fire = "/SECTION 5[\s\S]*?5\.1[\s\S]*?\n\K[\s\S]*(?=5\.3 Advice)/";
$rgx_props = "/Information on basic physical and chemical properties\W*\K(?:.*\s)*?(?=9\.2 Other)/";
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
	$match = $info[0];
	// $info[0] = trim($info[0]);
	if ($key == 'props') {
		$match = preg_replace("/\n(?!([a-z]\)))/", "", $match);
		$match = preg_replace("/(^|\n)[a-z]\)(.*)/", "<li>$1$2</li>", $match);
	}
	if ($key == 'formula') $match = preg_replace("/([^\d])(\d+)/", "$1<sub>$2</sub>", $match);
	if ($key == 'mw') $match = $match . " g/mol";
	if ($key == 'fire') {
		$match = preg_replace("/([\S\s]*?)(?:Unsuitable extinguishing media\s*([\S\s]*))?(?:5\.2.*or mixture\s*)([\S\s]*)/", "<b>Suitable:</b> $1\n<b>Unsuitable:</b> $2\n<b>Special hazards:</b> $3", $match);
		$match = preg_replace("/\n{2,}/", "\n", $match);
	}
?>
	<br>
	<h4><?= $values[0] ?></h4>
	<pre class="<?= $key ?>"><?= $info[0] ?></pre>
	<script>
		console.log(<?= json_encode($match) ?>);
		if (<?= json_encode($key) ?> == 'props') {
			var for_summary = <?= json_encode("<h4>" . $values[0] . "</h4><hr><ol type=a>" . $match . "</ol>") ?>;
		} else {
			var for_summary = <?= json_encode("<h4>" . $values[0] . "</h4><hr><p>" . $match . "</p>") ?>;
		}
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