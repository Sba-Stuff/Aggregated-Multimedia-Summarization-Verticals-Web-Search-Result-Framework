<?php
function generateHTMLLinks($terms) {
    $links = array();

    foreach ($terms as $term) {
    $link = "<a href=\"myimagesearch.php?term={$term}\">{$term}</a>";
    $links[] = $link;
}

    $result = implode(' | ', $links);

    return $result;
}
function removeStopwords($terms) {
    // Load the stopwords from the file
    $stopwords = file("stopwords.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $cleanTerms = array_filter($terms, function($term) use ($stopwords) {
        return strlen($term) > 2 && !in_array($term, $stopwords);
    });

    return $cleanTerms;
}
function isTermLikeUrl($term)
{
    $bHasLink = strpos($term, 'http') !== false || strpos($term, 'www.') || strpos($term, '.com') !== false;
    if($bHasLink){ return true;}else{    return false;}
}

function extractTextualTermsFromTable($html)
{
    $dom = new DOMDocument();
    libxml_use_internal_errors(true); // Disable libxml errors
    $dom->loadHTML($html);

    $xpath = new DOMXPath($dom);

    $terms = [];

    // Find all text nodes within the table
    $textNodes = $xpath->query('//table//text()');

    foreach ($textNodes as $textNode) {
        $term = trim($textNode->nodeValue);
	$term = str_replace('.', ' ', $term);
        // Ignore empty terms and terms that look like URLs
        if ($term !== '' && !isTermLikeUrl($term)) {
		$termParts = explode(' ', strtolower($term));
            foreach ($termParts as $termPart) {
                $terms[] = $termPart;
            }
        }
    }
    $uniqueTerms = array_unique($terms);

    return generateHTMLLinks(removeStopwords($uniqueTerms));
}

function returnVideoResults($query)
{
    $encodedQuery = urlencode($query);
    $url = "https://www.youtube.com/results?search_query={$encodedQuery}";
    $html = file_get_contents($url);
$html = str_replace('"', ' ', $html);

// Explode HTML content on spaces
$items = explode(' ', $html);

// Initialize an array to store URLs containing "watch?v="
$urls = [];

// Iterate over each item
foreach ($items as $item) {
    // Check if the item contains "watch?v=" and "\u0026pp"
    if (strpos($item, 'watch?v=') !== false && strpos($item, '\u0026pp') !== false) {
        // Extract the URL before "\u0026pp"
        $url = substr($item, 0, strpos($item, '\u0026pp'));
        
        // Add the URL to the array
        $urls[] = $url;
    }
}
$urls = array_unique($urls);
return $urls;
}

function getTablesByClass($html, $class)
{
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $tables = $dom->getElementsByTagName('table');
    $filteredTables = [];
    foreach ($tables as $table) {
        $classAttr = $table->getAttribute('class');
        if ($classAttr === $class) {
            // Get the outer HTML of the table
            $tableHtml = $dom->saveHTML($table);
            $filteredTables[] = $tableHtml;
        }
    }
    return $filteredTables;
}

if(isset($_GET["query"]))
{
if(isset($_GET["term"])){echo "Lol";}
else{
//set_time_limit(50);
ini_set('display_errors', 0);
include("ytapi.php");
$urls = returnVideoResults($_GET["query"]);
foreach ($urls as $url) {
    echo generateresult($url);
}
}
}
?>
