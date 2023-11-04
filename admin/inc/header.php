<?php

session_start();
require_once("config.php");

if($_SESSION['key'] != "AdminKey"){
    echo "<script>location.assign('logout.php')</script>";
    die;
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Online Voting System</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body >


<div class="container-fluid">
    <div class="row  text-white" style="background-color: #687EFF;">
        <div class="col-2">
            <img src="../assets/images/logo2.gif" width="80px" height="100%" alt="Logo" />
        </div>
        <div class="col-10 my-auto">
            <h1>Online Voting System</h1>
            <p>Welcome, <?php echo $_SESSION['username']; ?></p>
        </div>
    </div>
</div>

    
