<?php

// Pv = nRT
// P = pressure (float)
// v = volume
// n = number of moles
// R = gas constant: 8.314
// T = temperature


// Get user input
echo "What is the pressure?";
$pressure = (float) readline("Pressure(float): ");

echo "What is the width?";
$width = (float) readline("Width: ");

echo "What is the height?";
$height = (float) readline("Height: ");

echo "What is the temperature?";
$temperature = (float) readline("Temperature: ") + 273.14;


// Calculate volume
$volume = $width * $height;

// Calculate number of moles
$moles = ($pressure * $volume) / (8.314 * $temperature);
echo "The number of moles is: " . $moles . "\n";

$moles = round($moles);
echo "The rounded number of moles is: " . $moles . "\n";

// Swap from odd to even and vice versa
$moles += 1;
echo "The swapped number of moles is: " . $moles . "\n";


?>