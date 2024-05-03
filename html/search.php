<?php session_start(); ?>

<?php
# Google search
$query = str_replace(" ", "%20", $_GET["molname"] . " \"Aldrich-\" \"product number\" site:sigmaaldrich.com filetype:pdf");
$link = "https://www.google.co.uk/search?q=" . $query;

try {
    $html = file_get_contents($link);
    
    # Searches through search results for product code
    $type = preg_match("/(?<=Brand\. : )(\w|-){2,15}/", $html, $match_type);
    $code = preg_match("/(?<=Product Number\. : )\w{2,10}/", $html, $match_code);
    
    if ($match_type[0] == "Sigma-Aldrich") $match_type[0] = "sial";
    
    $sds = "https://www.sigmaaldrich.com/GB/en/sds/" . strtolower($match_type[0]) . "/" . $match_code[0];
    $_SESSION["sds"] = $sds;

    if (strlen($match_code[0])) {
        if(file_put_contents("sds.pdf", file_get_contents($sds))) {
            header("Location: /?status=success");
            exit;
        } else {
            throw new Exception("Error: SDS could not be opened");
        }
    } else {
        throw new Exception("Error: SDS not found");
    }

} catch (\Throwable $th) {
    $_SESSION["throw"] = $th->getMessage();
    header("Location: /?status=failed");
    exit;
}
?>