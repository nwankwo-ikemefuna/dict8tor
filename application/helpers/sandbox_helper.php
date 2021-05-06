<?php 

function groupByAssociation(array $files) : array {
    if (empty($files)) return [];
    $groupedFiles = [];
    foreach ($files as $fileName => $owner) {
        $groupedFiles[$owner][] = $fileName;
    }
    return $groupedFiles;
}

$files = array(
    "Input.txt" => "Randy",
    "Code.py" => "Stan",
    "Output.txt" => "Randy"
);