<?php
session_start();
require ("config.php");
require ("function.php");
$link = mysqli_connect($servername, $username, $password, $dbname);
if (!$link) {
    die("连接失败: " . mysqli_connect_error());
}


if($_POST['submit']){
    $username = $_POST['username'];
    $pwd = $_POST['password'];
    //用户名和密码不能为空：pass
    if($username == "" || $pwd == ""){
        require ("header.php");
        echo "<script>alert('用户名或密码不能为空 ！');history.go(-1);</script>";
    }else{
        //验证用户名和密码:pass
        $sql = "SELECT * FROM admin
            WHERE username='".$_POST['username']."' AND password='".$_POST['password']."';";
        $result=mysqli_query($link,$sql);
        $numrows = mysqli_num_rows($result);

        if($numrows == 1){
            $row = mysqli_fetch_assoc($result);
            $_SESSION['ADMIN'] = $row['username'];

            //重定向：如果接到到别的页面传过来的ref值：即addcat.php的cat值。
            //此时用户如果没有登录，直接通过url想要浏览，则禁止这种行为，转向登录。
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

?>
    <form action="<?php echo pf_script_with_get($SCRIPT_NAME); ?>" method="post">
        <!--pass-->
       <div class="fill">
           <h1>管理员登录</h1>
                <input type="text" name="username" placeholder="用户名" ><br/>
                <input type="password" name="password" placeholder="密码"><br/>
                <input type="submit" name="submit" value="登录">
       </div>
    </form>
    <?php
}
require("footer.php");
?>
