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
//function removeStopwords($terms) {
//    // Load the stopwords from the file
//    $stopwords = file("stopwords.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//
//    $cleanTerms = array_filter($terms, function($term) use ($stopwords) {
//        return strlen($term) > 2 && !in_array($term, $stopwords);
//    });
//
//    return $cleanTerms;
//}
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

function returnImageResults($query)
{
    $encodedQuery = urlencode($query);
    $url = "https://www.google.com/search?tbm=isch&q={$encodedQuery}";
    $html = file_get_contents($url);
    $tables = getTablesByClass($html, 'GpQGbf');
    if ($tables) {
        $tableHtml = $tables[0];
		$dom = new DOMDocument;
        libxml_use_internal_errors(true);
        @$dom->loadHTML($tableHtml);
        $xpath = new DOMXPath($dom);
        $imageTags = $xpath->query('//img');
        $count = 0;
		$g = "";
        foreach ($imageTags as $imageTag) {
            $src = $imageTag->getAttribute('src');
            $g = $g."<img src='$src' alt='Image $count'>";
            $count++;
            if ($count == 10) {
                break;
            }
        }
//echo $tableHtml;
        //$terms = extractTextualTermsFromTable($tableHtml);
        //print_r($terms);
		return $g;
    } else {
        return 'Table not found.';
    }
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

//if(isset($_GET["query"]))
//{
//if(isset($_GET["term"])){echo "Lol";}
//else{returnImageResults($_GET["query"]);}
//}
?>
