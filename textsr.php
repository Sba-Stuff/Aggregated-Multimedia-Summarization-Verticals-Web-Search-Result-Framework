<head>
<link rel="stylesheet" href="css/resultsnippet.css">
</head>
<?php
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
function removeStopwords($terms) {
    // Load the stopwords from the file
    $stopwords = file("stopwords.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $cleanTerms = array_filter($terms, function($term) use ($stopwords) {
        return strlen($term) > 2 && !in_array($term, $stopwords);
    });

    return $cleanTerms;
}
function extractTextAfter($inputString, $searchString) {
    $position = strstr($inputString, $searchString);
    if ($position !== false) {
        $textAfter = substr($position, strlen($searchString));
        $explodedArray = explode(' ', $textAfter);
        return $explodedArray;
    }
    return [];
}
function getPlainTextContent($html)
{
    // Create a new DOMDocument instance
    $dom = new DOMDocument;
    // Suppress errors and warnings for invalid HTML
    libxml_use_internal_errors(true);
    // Load the HTML content into the DOMDocument
    $dom->loadHTML($html);
    // Restore error reporting
    libxml_use_internal_errors(false);

    // Remove unwanted elements (e.g., script, style)
    $unwantedTags = ['script', 'style'];
    foreach ($unwantedTags as $tagName) {
        $elements = $dom->getElementsByTagName($tagName);
        foreach ($elements as $element) {
            $element->parentNode->removeChild($element);
        }
    }

    // Extract the plain text content
    $textContent = $dom->textContent;

    // Remove leading and trailing whitespace
    $textContent = trim($textContent);

    // Return the plain text content
    return $textContent;
}
function divstext($text)
{
$text = strtolower($text);
$text = trim($text,"");
$text = preg_replace('/[^a-z0-9]/i', ' ', $text);
//if (strpos($text, ' ') !== false) {echo "Lol";}
//echo "<b>".$text."</b></br></br>";
}

function testdoc($query)
{
 $encodedQuery = urlencode($query);
    $url = "https://www.google.com/search?&q={$encodedQuery}";
    $html = file_get_contents($url);
    $dom = new DOMDocument;
    libxml_use_internal_errors(true);
	@$dom->loadHTML($html);
	$xpath = new DOMXPath($dom);
	$divsWithLink = $xpath->query('//div[contains(@class, "egMi0") and contains(@class, "kCrYT")]');
	$divsWithDescription = $xpath->query('//div[contains(@class, "BNeawe") and contains(@class, "s3v9rd") and contains(@class, "AP7Wnd")]');
	for ($i = 0; $i < $divsWithLink->length; $i++) {
		$linkDiv = $divsWithLink->item($i);
		$descriptionDiv = $divsWithDescription->item($i);
		$linkElement = $linkDiv->getElementsByTagName('a')->item(0);
		$heading = $linkElement->nodeValue;
		$link = $linkElement->getAttribute('href');
		$link = str_replace('url?q=', 'viz/url.php?link=', $link);
		$description = $descriptionDiv->textContent;
		// Now you can do whatever you want with the link and description
	   	// echo "Link: " . $link . "\n";
		//echo "Description: " . $description . "\n";
		include_once("titlegen.php");
		include_once("imagesr.php");
		echo "<button class=\"collapsible\">".generateTitleFromParagraph($description)."</button>";
		echo "<div class=\"content\">";
		echo "<b>Summary</b>. <a href='".$link ."' target='_blank'>Vist the link for more detailed information</a></br>";
		echo $description."</br>";
		echo "<b>Images</b></br>";
		echo returnImageResults($description);
		echo "<br>";
		echo "<b>Videos</b></br>";
		set_time_limit(50);
		ini_set('display_errors', 0);
		include_once("ytapi.php");
		$urls = returnVideoResults($description);
		if (isset($urls[0])) {echo generateresult($urls[0]);}
		if (isset($urls[1])) {echo generateresult($urls[1]);}
		if (isset($urls[2])) {echo generateresult($urls[2]);}
		if (isset($urls[3])) {echo generateresult($urls[3]);}
		if (isset($urls[4])) {echo generateresult($urls[4]);}
		//echo "Heading: ".generateTitleFromParagraph($description)."</br> Description: <a href='".$link."'>" . $description . "</a><br><br>";
		echo "</div>";
		echo "</br>";
	}
}
function returnTextResults2($query)
{
    $encodedQuery = urlencode($query);
    $url = "https://www.google.com/search?&q={$encodedQuery}";
    $html = file_get_contents($url);
    $dom = new DOMDocument;
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    libxml_use_internal_errors(false);
    $xpath = new DOMXPath($dom);
    $divs = $xpath->query("//div[@id='main']");
    foreach ($divs as $div) {
        $kp7lcbDivs = $div->getElementsByTagName('div');
        foreach ($kp7lcbDivs as $kp7lcbDiv) {
            if ($kp7lcbDiv->getAttribute('class') === 'KP7LCb') {
                $kp7lcbDiv->parentNode->removeChild($kp7lcbDiv);
            }
        }
        $childNodes = $div->childNodes;
        for ($i = $childNodes->length - 1; $i >= 0; $i--) {
            $child = $childNodes->item($i);
            if ($child->nodeName !== 'div') {
                $div->removeChild($child);
            }
        }
        return $dom->saveHTML($div);
    }
}

function returnTextResults($query)
{
    $encodedQuery = urlencode($query);
    $url = "https://www.google.com/search?&q={$encodedQuery}";
    $html = file_get_contents($url);

    // Create a new DOMDocument instance
    $dom = new DOMDocument;
    // Suppress errors and warnings for invalid HTML
    libxml_use_internal_errors(true);
    // Load the HTML content into the DOMDocument
    $dom->loadHTML($html);
    // Restore error reporting
    libxml_use_internal_errors(false);

    // Create a new DOMXPath instance
    $xpath = new DOMXPath($dom);

    // Query the DOMXPath to select div elements with id='main'
    $divs = $xpath->query("//div[@id='main']");
    $divs2 = $xpath->query("//div[contains(.,'People also ask') or contains(.,'Related searches') or contains(.,'Images') or contains(.,'Top stories')]");
foreach ($divs2 as $div2) {
    $parent2 = $div2->parentNode;
    $parent2->removeChild($div2);
}
$finalHtml = '';
    // Iterate over the selected divs and remove the footer and KP7LCb divs from each div
    foreach ($divs as $div) 
	{
        $footer = $div->getElementsByTagName('footer')->item(0);
        if ($footer) {
            $footer->parentNode->removeChild($footer);
        }

        $kp7lcbDivs = $div->getElementsByTagName('div');
        foreach ($kp7lcbDivs as $kp7lcbDiv) {
            if ($kp7lcbDiv->getAttribute('class') === 'KP7LCb') {
                $kp7lcbDiv->parentNode->removeChild($kp7lcbDiv);
            }
			//divstext($kp7lcbDiv->textContent);
        }
		$links = $div->getElementsByTagName('a');
    // Loop through each hyperlink and replace "url?q=" with your desired URL
    foreach ($links as $link) {
        $href = $link->getAttribute('href');
        $newHref = str_replace('url?q=', 'viz/url.php?link=', $href);
        $link->setAttribute('href', $newHref);
		$link->setAttribute('target', '_blank');
		
    }
	//$finalHtml .= "<table border='1'><tr><td>".$dom->saveHTML($div)."</td></tr></table><br>";
	//return "<table border='1'><tr><td>".$dom->saveHTML($div)."</td></tr></table>";
    //return $dom->saveHTML($div);
    }
	return $dom->saveHTML($div);
	//return $finalHtml;
}

// Example usage
//$result = returnTextResults2("Hello World in C#");
//$plainTextOuterHTML = getPlainTextContent($result);
//$extractedText = extractTextAfter($plainTextOuterHTML, "Verbatim");
//$result = implode(' | ',(removeStopwords($extractedText)));
//echo $result;
//echo $plainTextOuterHTML;
//echo returnTextResults("General Asim Munir");
//print_r($results);
?>
<?php
if(isset($_GET["query"]))
{
if(isset($_GET["term"])){$returnedResults = returnTextResults2($_GET["query"]);}
//else{echo returnTextResults($_GET["query"]); testdoc($_GET["query"]);}
else{echo testdoc($_GET["query"]);}
}
?>
<script src="js/resultsnippet.js"></script>

