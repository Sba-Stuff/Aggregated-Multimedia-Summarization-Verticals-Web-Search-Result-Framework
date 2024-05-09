<?php
function generateTitleFromParagraph($paragraph) {
    // List of common stop words to be removed
    $stopWords = array('the', 'and', 'a', 'an', 'in', 'on', 'of', 'to', 'for', 'with', 'at', 'by', 'is', 'are', 'as', 'it', 'that', 'this', 'we', 'you', 'they', 'i', 'he', 'she', 'me', 'him', 'her', 'us', 'them');
    
    // Convert paragraph to lowercase and remove punctuation
    $paragraph = strtolower(preg_replace('/[^a-z0-9\s]/i', '', $paragraph));
    
    // Tokenize the paragraph into words
    $words = explode(' ', $paragraph);
    
    // Count the frequency of each word
    $wordCounts = array_count_values($words);
    
    // Remove stop words
    foreach ($stopWords as $stopWord) {
        unset($wordCounts[$stopWord]);
    }
    
    // Sort the words by frequency in descending order
    arsort($wordCounts);
    
    // Take the first few high-scoring words and combine them to form the title
    $titleWords = array_slice(array_keys($wordCounts), 0, 5); // Change 5 to the desired number of words in the title
    
    // Capitalize the first letter of each word and join them to form the title
    $title = ucwords(implode(' ', $titleWords));
    
    return $title;
}


// Example usage:
//$paragraph = "This is a sample paragraph. It contains some text that we want to analyze and generate a title from.";
//$title = generateTitleFromParagraph($paragraph);
//echo $title;
?>
