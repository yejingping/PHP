<?php
if($_POST['submit']){
    $username = $_POST['username'];
    $pwd = $_POST['password'];
    if($username == "" || $pwd == ""){
        echo "<script>alert('用户名或密码不能为空 ！');history.go(-1);</script>";
    }else{
        $sql = "SELECT * FROM admins 
            WHERE username='".$_POST['username']."' AND password='".$_POST['password']."';";
        $result=mysqli_query($link,$sql);
        $numrows = mysqli_num_rows($result);

        if($numrows == 1){
            $row = mysqli_fetch_assoc($result);

            $_SESSION['ADMIN'] = $row['username'];

            switch ($_GET['ref']) {
                case "add":
                    header("Location:" . $config_basedir . "/addforum.php");
                    break;

                case "cat":
                    header("Location:" . $config_basedir . "/addcat.php");
                    break;

                case "del":
                    header("Location:" . $config_basedir);
                    break;

                default:
                    header("Location:" . $config_basedir);
                    break;
            }
        }else{
            header("Location:".$config_basedir."/admin.php?error=1");
        }
    }
}else{
    require ("header.php");
    if($_GET['error']){
        echo "<script>alert('用户名或密码不正确！');</script>";

    }
}


?>