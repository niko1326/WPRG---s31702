<?php
for($i = 1; $i <=10; $i++){
    echo "Hello World $i!<br>";
}

echo "<table>";
for($i = 1; $i <=10; $i++){
    echo "<tr>";
    for($j = 2; $j <= 10; $j++){
        echo "<td>$i</td>";
        echo "<td>$j</td>";
        $k = pow($i, $j);
        echo "<td>$k</td>";
    }
    echo "</tr>";
}
echo "</table>";

$stopy = 60;
echo "<br>$stopy stóp = ";
echo $stopy * 0.3;
echo " metrów<br>";

$r = 15;
$h = 25;
echo "Objętość cylindra o promieniu $r i wysokości $h: ";
echo pi() * pow($r, 2) * $h;
echo"<br>";

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
echo "<br><br>";

echo "<ul>    ";
for($i = 2; $i <= 20; $i+=2){
    echo "<li>$i</li>";
}
echo "</ul>";

echo date('d-m-Y');