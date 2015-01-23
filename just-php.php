<? php

// database connection must be performed here or previously in the webpage

// following SQL statement reflects minimum necessary database tables & fields
// see keyword master list for suggested entry to the keyword field

$stmt3 = $pdo->prepare("SELECT `jobs-table`.`job-description-field`, `keywords-table`.`keywords-field` 
    FROM `jobs-table`, `keywords-table` 
    WHERE `jobs-table`.`job-id-field`= '$jobId';"); 
    //requires POST-ed or hard-coded job id (primary key of jobs-table) for $jobId variable

$stmt3->execute();

$output = "";


while($row = $stmt3->fetch()) { 

    function multiexplode ($delimiters,$string) {
    //$delimiters has to be array
    //$string has to be array
        
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    } // end multiexplode

    $keywordString = strtolower($row["keywords-field"]);
    //convert all to lowercase in preparation for matching
    $keywordArray = multiexplode(array(",",".","|",":"," "),$keywordString); 
    //convert keyword-field contents from string to array

    $descString = strtolower($row["job-description-field"]);
    //convert all to lowercase in preparation for matching
    $descArray = multiexplode(array(",",".","|",":"," "),$descString);
    //convert job-description-field contents from string to array

    $comparison = array_intersect($keywordArray, $descArray);
    //compare two arrays & return matches

    $noDuplicates = array_unique($comparison);
    //remove duplicate responses

    foreach($noDuplicates as $val) {
    //loop through all non-duplicate outputs
?>
