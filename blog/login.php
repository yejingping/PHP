<?php
session_start();
require ("config.php");
$link = mysqli_connect($servername, $username, $password, $dbname);
if($_POST['submit']) {
    if (!$link) {
        die("连接失败: " . mysqli_connect_error());
    }
    $sql = "SELECT *
            FROM logins
            WHERE username = '" . $_POST['username'] . "' AND password = '" . $_POST['password'] . "';
            ";
    $result = mysqli_query($link, $sql);
    $numrows = mysqli_num_rows($result);
    if ($numrows == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['USERNAME'] = $row['username'];
        $_SESSION['USERID'] = $row['id'];
        header("Location:" . $config_basedir);
    } else {
        header("Location:" . $config_basedir . "/login.php?error=1");
    }

}else{
    require ("header.php");
    if($_GET['error']){
        echo "登录错误，请再次尝试！";
    }
}
?>

<form action="<?php echo $SCRIPT_NAME?>" method="post">
    <fieldset>
        <legend>登录</legend>
        <p>
            <label for="username">用户名</label>
            <input type="text" name="username" id="username">
        </p>
        <p>
            <label for="password">密码</label>
            <input type="password" name="password" id="password">
        </p>
        <p>
            <input type="submit" name="submit" value="登录" id="submit">
        </p>
    </fieldset>

</form>
<?php require ("footer.php")?>
