<?php
session_start();
require ("config.php");
$link = mysqli_connect($servername, $username, $password,$dbname);
if (!$link) {
    die("连接失败: " . mysqli_connect_error());
}
?>

<html>
<head>
    <title><?php echo $config_forumsname; ?></title>
    <link rel="stylesheet" href="css/stylesheet.css" type="text/css"/>
    <script type="text/javascript" rel="script" src="js/form.js"></script>
</head>
<body>
<div id="header">
    <p id="subject">电影论坛</p>
    <p id="link">
        <a href="index.php">主页|</a>
        <a href="newtopic.php">新话题|</a>
        <!--检查session是否存在-->
    <?php
        if(isset($_SESSION['USERNAME']) == TRUE){
            echo "<a href = 'logout.php'>退出|</a>";
        }else{
            echo "<a href='login.php#fill'>登录|</a>";
            echo "<a href='register.php#fill'>注册|</a>";
        }
    ?>
    </p>
</div>
<div id="main">



