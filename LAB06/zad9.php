<?php randomizeThree();


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

?>

