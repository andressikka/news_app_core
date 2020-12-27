<?php
    session_start();
    // echo session_id();
    if(!isset($_SESSION['username'])){
        header("Location:login.php");
    }
    require_once("./viewparts/head.php");
?>
<body class="bg-light">
<?php 
    require_once("./viewparts/nav.php");
    require_once("../index.php"); 
?>
</body>
</html>