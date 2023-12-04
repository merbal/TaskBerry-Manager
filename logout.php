<?php 

session_start();
if (isset($_SESSION['user_id']))
{

    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_acc_id']);
   
}
header("Location: ../index.php");
die;
?>
