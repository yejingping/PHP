<?php
    //该页无效，没有开启邮箱设置！！！要安装SMTP服务器
    require ("header.php");
    $verifystring = urldecode($_GET['verify']);
    $verifyemail = urldecode($_POST['email']);

    $sql = "SELECT id FROM users
            WHERE verifystring='".$verifystring."' AND email='".$verifyemail."';
            ";
    $result = mysqli_query($link,$sql);
    $numrows = mysqli_num_rows($result);

    if($numrows == 1) {
        $row = mysqli_fetch_assoc($result);
        $sql = "UPDATE users active = 1
                WHERE id=" . $row['id'] . ";
                ";
        $result = mysqli_query($link, $sql);
        echo "你的账号已经成功验证，现在你可以点击<a href='login.php'>登录</a>";
    }else{
        echo "该账号没有验证成功！";
    }
    require ("footer.php");
?>