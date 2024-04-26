<html>
<p>Kapibara je marchewke!</p>
<?php if(kapibaraJeMarchewke()) {?>
    <img src="carrot.png">
    <?php }else{?>
    <p>Kapibara zjadła marchewke!</p>
<?php }?>

<?php
function kapibaraJeMarchewke()
{
    if(rand(1,10) > 4) return true;
    return false;
}
?>
</html>