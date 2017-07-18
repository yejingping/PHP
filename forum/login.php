<?php
session_start();
require ("config.php");
require("function.php");
$link = mysqli_connect($servername, $username, $password, $dbname);
if (!$link) {
    die("连接失败: " . mysqli_connect_error());
}
if ($_POST['submit']){
    $sql = "SELECT * FROM users 
            WHERE username='".$_POST['username']."' AND password='".$_POST['password']."';";
    $result=mysqli_query($link,$sql);
    $numrows = mysqli_num_rows($result);

    if($numrows == 1){
        $row = mysqli_fetch_assoc($result);
        if($row['active'] == 1){
            $_SESSION['USERNAME'] = $row['username'];
            $_SESSION['USERID']=$row['id'];

            switch ($_GET['ref']){
                case "newpost":
                    if(isset($_GET['id']) == FALSE){
                        header("Location:".$config_basedir."/newtopic.php");
                    }else{
                        header("Location:".$config_basedir."/newtopic.php?id=".$_GET['id']."");
                    }
                    break;

                case "reply":
                    if(isset($_GET['id']) == FALSE){
                        header("Location:".$config_basedir."/reply.php");
                    }else{
                        header("Location:".$config_basedir."/reply.php?id=".$_GET['id']."");
                    }
                    break;

                default:
                    header("Location:".$config_basedir);
                    break;
            }
        }
        else{
            require ("header.php");
            echo "该账号尚未验证。已向你的邮箱发送链接验证，请点击链接完成验证。";
        }
        echo "该账号尚未验证。已向你的邮箱发送链接验证，请点击链接完成验证。";
    }
    else{
        header("Location:".$config_basedir."/login.php?error=1");
    }
}else {
    require("header.php");
    if ($_GET['error']) {
        echo "<script>alert('用户名或密码不正确，请再次尝试登录！');history.go(-1);</script>";
    }
    ?>


    <form action="<?php echo pf_script_with_get($SCRIPT_NAME); ?>" method="post">
        <div class="fill" id="fill">
                <h1>用户登录</h1>
                <input type="text" id="username" name="username" placeholder="用户名/电子邮箱"><br/>
                <input type="password" name="password" id="password" placeholder="密码"><br/>
                <input type="submit" name="submit" value="登录"><br/>

            <p>还没有一个账号？快来注册一个吧！<br/>点击<a href="register.php">注册</a></p>
        </div>
    </form>
    <?php
}
    require("footer.php");
?>