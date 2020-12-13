<?php
    session_start();
    // echo session_id();
    if(!isset($_SESSION['username'])){
        header("Location:login.php");
    }
    require_once("./viewparts/head.php");
?>
<body class="bg-light">
<?php require_once("viewparts/nav.php");?>
<?php require_once("../index.php"); ?>
</body>
</html>

<?php

    // if(isset($_GET['page'])){
    //     include_once($_GET["page"].".php");
    // } else{
    //     include_once('adminView.php');
    // }