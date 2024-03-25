<?php

// 1) Create a function that takes two 
//    numbers as arguments and returns 
//    their sum?
function add($num1, $num2) {
    return $num1 + $num2;
}

// 2) Create a function that takes a 
//    number as an argument, increments 
//    the number by +1 and returns the 
//    result.
function add1($num) {
    return $num + 1;
}

// 3) Write a function that takes an 
//    integer minutes and converts it to 
//    seconds.
function minutesToSeconds($minutes) {
    return $minutes * 60;
}

// 4) Write a function that takes the 
//    base and height of a triangle 
//    and return its area.
function areaOfTriangle($base, $height) {
    return ($base * $height) / 2;
}

// 5) Create a function that finds the 
//    maximum range of a triangle's third 
//    edge, where the side lengths are all 
//    integers.
function nextEdge($side1, $side2) {
    return ($side1 + $side2) - 1;
}

// 6) Create a function that takes an 
//    array containing only numbers and return 
//    the first element.
function getFirstValue($arr) {
    return $arr[0];
}

// 7) Create a function that takes a 
//    number as its only argument and returns 
//    true if it's less than or equal to zero, 
//    otherwise return false.
function lessThanOrEqualToZero($num) {
    return $num <= 0;
}

// 8) There is a single operator in PHP, 
//    capable of providing the remainder of a 
//    division operation. Two numbers are passed 
//    as parameters. The first parameter divided 
//    by the second parameter will have a remainder, 
//    possibly zero. Return that value.
function remainder($num1, $num2) {
    return $num1 % $num2;
}

// 9) Create a function that returns true if a 
//    string is empty and false otherwise.
function isEmptyString($str) {
    return $str === "";
}

// 10) Given two strings, firstName and lastName, 
//     return a single string in the format "last, 
//     first".
function makeName($firstName, $lastName) {
    return $lastName . ", " . $firstName;
}

?>