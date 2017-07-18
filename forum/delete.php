<?php
require ("config.php");

$link = mysqli_connect($servername, $username, $password, $dbname);
if (!$link) {
    die("连接失败: " . mysqli_connect_error());
}

//检查GET变量
if(isset($_GET['id']) == TRUE){
    if(is_numeric($_GET['id']) == FALSE){
        header("Location:".$config_basedir);
    }else{
        $validid = $_GET['id'];
    }
}else{
   header("Location:".$config_basedir);
}

//删除
switch ($_GET['func']){
    //删除分类
    case "cat":
        $delsql = "DELETE FROM categories WHERE id=".$validid.";";
        mysqli_query($link,$delsql);
        header("Location:".$config_basedir);
        break;
    //删除版块
    case "forum":
        $delsql = "DELETE FROM forums WHERE id=".$validid.";";
        mysqli_query($link,$delsql);
        header("Location:".$config_basedir);
        break;
    //删除帖子
    case "thread":
        $delsql = "DELETE FROM topics WHERE id=".$validid.";";
        mysqli_query($link,$delsql);
        header("Location:".$config_basedir."viewforum.php?id=".$_GET['forum']);
        ///
        break;

    default:
        header("Location:".$config_basedir);
        break;
}

?>