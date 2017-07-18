<?php
session_start();
require ("config.php");
require ("function.php");

//回复主题

$link = mysqli_connect($servername, $username, $password, $dbname);
if (!$link) {
    die("连接失败: " . mysqli_connect_error());
}
//对GET变量验证
if(isset($_GET['id']) == TRUE){
    if(is_numeric($_GET['id']) == FALSE){
        header("Location:".$config_basedir);
    }else{
        $validtopic = $_GET['id'];
    }
}else{
    header("Location:".$config_basedir);
}

//检查用户是否登录
if(isset($_SESSION['USERNAME']) == FALSE){
    header("Location:".$config_basedir."/login.php?ref=reply&id=".$validtopic."");
}

//处理表单
if($_POST['submit']){
    $messagesql = "INSERT INTO messages(date,user_id,topic_id,subject,body)
                   VALUES (NOW(),
                            ".$_SESSION['USERID'].",
                            ".$validtopic.",
                            '".$_POST['subject']."',
                            '".$_POST['body']."');
                            ";
    mysqli_query($link,$messagesql);
    header("Location:".$config_basedir."/viewmessages.php?id=".$validtopic."");
}else {
    require("header.php");


    ?>
    <form action="<?php echo pf_script_with_get($SCRIPT_NAME); ?>" method="post">
        <div class="fill">

            <h1>回复帖子</h1>
            <div id="fill_t">
            <p>
                <label for="title">标题:</label>
                <input type="text" name="subject" id="title">
            </p>
            <p>
                <label for="body">内容:</label>
                <textarea name="body" id="body" rows="10" cols="50"></textarea>
            </p>
            </div>
            <p>
                <input type="submit" name="submit" value="发表">
            </p>

        </div>
    </form>

<?php
}
require ("footer.php");
?>