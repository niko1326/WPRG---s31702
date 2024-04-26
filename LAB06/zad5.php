<?php

$samogloski  = ['a', 'o', 'i', 'e', 'u', 'y'];
$string = "happiness";
$counter = 0;
$realcounter = 0;
for ($i = 0; $i < strlen($string); $i++) {
    for ($j = 0; $j < count($samogloski); $j++) {
        if($string[$i] != $samogloski[$j]){
            $counter++;
        }
    }
    if($counter > 5){
        $realcounter++;
        $counter = 0;
    }
}
echo $realcounter;