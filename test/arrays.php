<?php

// for array

$array_example = []; //empty array

$array_example_2 = ["tobi"];

$array_example_3 = ["tobi", 3, "learning", "php", true];

// Index - position of an element(item) in the array
// position starts from 0

print $array_example_3[0];  //prints out tobi
print $array_example_3[3];  //prints out true

// print out total element in an array

print count($array_example_3); // prints 4

// fetch the last item in the array

$imaginary_array = [];

print $imaginary_array[count($imaginary_array) - 1];

// ANother thrick to write array

$array_example_4 = array();

$array_example_4[0] = "Oluwatobiloba";
$array_example_4[1] = "is";
$array_example_4[2] = "nice";

print $array_example_4; // ['Oluwatobiloba', 'is' 'nice']
