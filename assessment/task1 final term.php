<?php

// Task 1
echo ("Task 1<br>");
$length = 50;
$width = 40;
$area= $length*$width;
echo ("Area: " . $area . "<br>");
$perimeter = 2 * ($length + $width);
echo ("Perimeter: " . $perimeter . "<br>");  //we cant use + symbol in php like we can in other language we use (.) ...we use br for line break

//Task 2
echo "Task 2<br>";
$price= 3000;
$vat = $price * 15 / 100;
echo ("VAT: " . $vat . "<br>");
$total = $price + $vat;
echo ("Total with VAT: " . $total . "<br>");

//Task 3
echo ("Task 3<br>");
$number = 10;
if ($number % 2 == 0) {
    echo ($number . " is even<br>");
} else {
    echo ($number . " is odd<br>");
}
echo ("<br>");

//Task 4
echo ("Task 4<br>");
$arr = array(34, 65, 99);
$max = $arr[0];
for ($i = 0; $i < 3; $i++) {
    if ($arr[$i] > $max) {
        $max = $arr[$i];
    }
}
echo ("Largest number: " . $max . "<br>");

// Task 5
echo "Task 5<br>";
for ($i = 10; $i <= 100; $i++) {
    if ($i % 2 != 0) {
        echo ($i . " ");
    }
}
echo ("<br>");

//Task 6
echo "Task 6<br>";
$n = array("ab", "bc", "cd");
$found = false;
for ($i = 0; $i < 3; $i++) {
    if ($n[$i] == "bc") {
        echo ("Found: " . $n[$i] . " at index " . $i . "<br>");
        $found = true;
    }
}
if (!$found) {
    echo ("Element not found<br>");
}