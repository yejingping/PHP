<?php
session_start();
require("config.php");
$link = mysqli_connect($servername, $username, $password, $dbname);
if (!$link) {
    die("连接失败: " . mysqli_connect_error());
}
?>
<html>
<head>
    <title>
        <?php echo $config_blogname; ?>
    </title>
    <link rel="stylesheet" href="css/body.css" type="text/css">
</head>
<body>
    <div id="header">
        <h1>
            <?php echo $config_blogname;?>
        </h1>
        [<a href="index.php">主页</a>]
        [<a href="viewcat.php">类目</a>]
        <?php
        if(isset($_SESSION['USERNAME']) == TRUE){
            echo " [<a href='logout.php' >注销</a>]";
        }else{
            echo "[<a href='login.php'>登录</a>]";
        }
        if(isset($_SESSION['USERNAME']) == TRUE){
            echo "-";
            echo "[<a href='addentry.php'>添加文章</a>]";
            echo "[<a href='addcat.php'>添加分类</a>]";
        }
        printf ("[用户名:%s]", $_SESSION['USERNAME']);
        ?>


    </div>



<div id="main">
