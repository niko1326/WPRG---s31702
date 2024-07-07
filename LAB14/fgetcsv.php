<?php
$file = fopen(" books . csv ", " r ");
if ($file !== FALSE) {
    $books = [];
    while (($data = fgetcsv($file, 1000, " ,")) !== FALSE) {
        print_r($data);
    }
    fclose($file);
} else {
    echo " Error in open file ";

}
?>