<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $userFile = 'data/' . $username . '_data.json';

    $userData = array(
        'todo_lists' => $_SESSION['todo_lists'],
        'current_list' => $_SESSION['current_list']
    );
    if (file_put_contents($userFile, json_encode($userData)) === false) {
        die('Error saving user data.');
    }
}

session_unset();
session_destroy();
header('Location: login.php');
exit;
?>
