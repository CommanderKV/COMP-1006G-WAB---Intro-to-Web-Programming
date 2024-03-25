<?php
// Question 1
function abs_val($number) {
    // If number is less than 0 or is 
    // negetive then make it positive
    if ($number < 0) {
        return $number * -1;
    } else {
        return $number;
    }
}

// Question 2
function rangeSum($a, $b) {
    // If a is less than b then 
    // get the sum of all the 
    // numbers from a to b.
    // Otherwise get the sum
    // of the numbers from b to a.
    if ($a < $b) {
        $sum = 0;
        for ($i = $a; $i <= $b; $i++) {
            $sum += $i;
        }
        return $sum;
    } else {
        $sum = 0;
        for ($i = $b; $i <= $a; $i++) {
            $sum += $i;
        }
        return $sum;
    }
}

// Get inputs for the rangeSum function.
echo "Please enter a positive number\n";
$a = readline("Number: ");

echo "Please enter another positive number\n";
$b = readline("Number: ");

echo "The sum of the numbers between $a(a) and $b(b) is " . rangeSum($a, $b) . "\n";


/*
Question 3

a) You would have to set $b to be 5.

b) function numPlayers(&$numPlayers) {...}

c) A refrence in php is a way to directly modify the value
    of a vairable without having to return, or make it global.
    This is done by using the & symbol before the variable name.
    You would want to use this when you are working with lots
    of data and dont want to return alot of things if its only
    getting modified once or very little. For example if I was 
    doing a search and I wanted to track how many iterations it went through
    I could use a refrence vairable to keep track of the number while still 
    only resturing the result of the search instead of both the result
    and the amount of interations.

d) To my knowledge there is no arraylist in PHP. There is an array though
    the arrays can be used to store multiple values in one vairable. You can
    also use them to store other arrays creating multi dimentional arrays.
    The length of an array is not defined so you can add as many elements as
    you want.

e) PHP is a server side programming languge. A server side languge is 
    a programming languge that is executed on the server and most of 
    the time the end user will never be able to see the code. A client
    side programming languge is a programming lanuge that is executed
    on the clients machine. The end user will always be interacting with
    these types of programming languages.
*/