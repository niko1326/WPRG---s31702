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
?>

<html>
<p>Kapibara je marchewke!</p>
<?php if(kapibaraJeMarchewke()) {?>
    <img src="carrot.png">
    <?php }else{?>
    <p>Kapibara zjadła marchewke!</p>
<?php }?>
<br><br>
<?php randomizeThree();?>
<br><br>
<form action="" method="post">
    <input type="text" id="pass" name="pass">
    <input type="submit" id="submit" name="submit" value="Check"> <br>
    <?php
        if(isset($_POST["submit"]))
        {
            checkPassword();
        }
    ?>
</form>


<?php
function kapibaraJeMarchewke()
{
    if(rand(1,10) > 4) return true;
    return false;
}
function randomizeThree()
{
    $temp1 = 0;
    $temp2 = 0;
    for($i = 0; $i < 3; $i++)
    {
        do{
            $rand = rand(1,9);
        } while ($rand == $temp1 || $rand == $temp2);
        if ($temp1 == 0) $temp1 = $rand;
        else $temp2 = $rand;
        echo "<img src='kapibara$rand.png'>";
    }
}

function checkPassword(){
    $pass = $_POST['pass'];
    if(strlen($pass) < 8) echo "Password is too short!<br>";
    if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $pass)) echo "You can't have special characters in your password!<br>";
    if(preg_match_all('/[1234567890]/', $pass, $array) < 2) echo "Password doesn't have enough digits!<br>";
}
?>

</html>