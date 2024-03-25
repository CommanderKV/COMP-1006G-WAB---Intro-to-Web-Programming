<?php
// Qualifications
global $isQualified, $vaildDiplomas;
global $yearsOfExperienceNeeded, $graduationDateNeeded, $skillNeeded;
$isQualified = false;
$vaildDiplomas = array(
    "CS", 
    "CP"
);
$yearsOfExperienceNeeded = "4";
$graduationDateNeeded = "2018";
$skillNeeded = "PHP";

function backgroundCheckWithFor($background) {
    global $isQualified, $vaildDiplomas;
    global $yearsOfExperienceNeeded, $graduationDateNeeded, $skillNeeded;

    // Go over each element in background array
    for ($i=0; $i < count($background); $i++) {
        // Look for the index of the element
        switch ($i) {
            // Check to see if the diploma is valid
            case 0:
                if (in_array(strtoupper($background[$i]), $vaildDiplomas)) {
                    $isQualified = true;
                } else {
                    return false;
                } 
                break;

            // Check to see if they have the required years of experience
            case 1:
                if ($background[$i] >= $yearsOfExperienceNeeded) {
                    $isQualified = true;
                } else {
                    return false;
                }
                break;

            // Check to see if they graduated in the required year
            case 2:
                if ($background[$i] >= $graduationDateNeeded) {
                    $isQualified = true;
                } else {
                    return false;    
                }
                break;

            case 3:
                if ($background[$i] === $skillNeeded) {
                    $isQualified = true;
                } else {
                    return false;
                }
                break;                
        }
        return $isQualified;
    }
}


// Get inputs from the user
$backGroundInfo = [];

echo "What is your diploma? (ex. CS Computer Science)\n";
$backGroundInfo[0] = readline("Diploma: ");

echo "How many years of experience do you have?\n";
$backGroundInfo[1] = readline("Years of experience: ");

echo "What year did you graduate?\n";
$backGroundInfo[2] = readline("Graduation year: ");

echo "What is your special skill?\n";
$backGroundInfo[3] = readline("Skill: ");



if (backgroundCheckWithFor($backGroundInfo)) {
    echo "You are eligible";
} else {
    echo "we decided to move on with other candidates";
}


?>