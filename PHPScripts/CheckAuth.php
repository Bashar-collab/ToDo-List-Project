<?php


function checkAuthentication(){
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    // If not authenticated, redirect to the login page
    header('Location: http://localhost/ToDoListProject/PHPScripts/Login.php');
    exit();
}

    // Unset the session variable to prevent direct access via URL after initial load
    if(time() > $_SESSION['expire'])
    {
        unset($_SESSION['authenticated']);
        header('Location: http://localhost/ToDoListProject/PHPScripts/Login.php');
        exit;
    }
    // echo "Authenticated";
}