<html>

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

</html>


<?php
function checkPassword(){
    $pass = $_POST['pass'];
    if(strlen($pass) < 8) echo "Password is too short!<br>";
    if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $pass)) echo "You can't have special characters in your password!<br>";
    if(preg_match_all('/[1234567890]/', $pass, $array) < 2) echo "Password doesn't have enough digits!<br>";
}
?>