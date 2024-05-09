<?php
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
    // Iterate over the selected divs and remove the footer and KP7LCb divs from each div
    foreach ($divs as $div) {
        $footer = $div->getElementsByTagName('footer')->item(0);
        if ($footer) {
            $footer->parentNode->removeChild($footer);
        }

        $kp7lcbDivs = $div->getElementsByTagName('div');
        foreach ($kp7lcbDivs as $kp7lcbDiv) {
            if ($kp7lcbDiv->getAttribute('class') === 'KP7LCb') {
                $kp7lcbDiv->parentNode->removeChild($kp7lcbDiv);
            }
        }

        return $dom->saveHTML($div);
    }
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

if(isset($_GET["query"]))
{
if(isset($_GET["term"])){$returnedResults = returnTextResults2($_GET["query"]);}
else{echo returnTextResults($_GET["query"]);}
}
?>
