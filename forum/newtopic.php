<?php
session_start();
require ("config.php");
require ("function.php");
$link = mysqli_connect($servername, $username, $password, $dbname);
if (!$link) {
    die("连接失败: " . mysqli_connect_error());
}

$forchecksql = "SELECT * FROM forums;";
$forcheckresult = mysqli_query($link,$forchecksql);
$forchecknumrows = mysqli_num_rows($forcheckresult);

if($forchecknumrows == 0){
    header("Location:".$config_basedir);
}

//接收到viewforum.php传值过来的id,哪个版块
if(isset($_GET['id']) == TRUE){
    if(is_numeric($_GET['id']) == FALSE){
        header("Location:".$config_basedir);
    }else{
        $validforum = $_GET['id'];
    }
}else{
    $validforum = 0;
}

//检查用户是否登录
if(isset($_SESSION['USERNAME']) == FALSE){
    header("Location:".$config_basedir."/login.php?ref=newpost&id=".$validforum);
}

//表单提交代码
if ($_POST['submit']) {
    if ($validforum==0) {
        $topicsql = "INSERT INTO topics(date,user_id,forum_id,subject) VALUES(NOW(),".$_SESSION['USERID'].",".$_POST['forum'].",'".$_POST['subject']."');";
    }else{
        $topicsql = "INSERT INTO topics(date,user_id,forum_id,subject) VALUES(NOW(),".$_SESSION['USERID'].",".$validforum.",'".$_POST['subject']."');";
    }
    mysqli_query($link,$topicsql);
    $topicid=mysqli_insert_id($link);

    $messagesql = "INSERT INTO messages(date,user_id,topic_id,subject,body)
                  VALUES (NOW(),
                  ".$_SESSION['USERID'].",
                  '$topicid',
                  '".$_POST['subject']."',
                  '".$_POST['body']."')
                  ";
    mysqli_query($link,$messagesql);
    header("Location:".$config_basedir."/viewmessages.php?id=".$topicid);
}else{
    require ("header.php");
    //如果$validforum不为零，则显示版块的名称
    echo "<div class='fill'>";

    if($validforum != 0 ){
        $namesql = "SELECT name From forums WHERE id =".$validforum." ";
        $nameresult = mysqli_query($link,$namesql);
        $namerow = mysqli_fetch_assoc($nameresult);
        echo "<h2>向".$namerow['name']."版块发表新的帖子</h2>";
    }else{
        //如果不是从版块链接过来的，则显示一般性的标题。
        echo  "<h2>发表新的帖子</h2>";
    }
    ?>

    <form action="<?php echo pf_script_with_get($SCRIPT_NAME)?>" method="post">
        <div id="fill_t">
            <?php
            if($validforum == 0) {
                $forumssql = "SELECT * FROM forums;";
                $forumsresult = mysqli_query($link, $forumssql);
                ?>
                <label>版块:</label>
                <select name="forum">
                    <?php
                    while ($forumsrow = mysqli_fetch_assoc($forumsresult)) {
                        echo "<option value='".$forumsrow['id']."'>".$forumsrow['name']."</option>";
                    }

                    ?>
                </select>
                <?php
            }
            ?>
            <p>
                <label for="headline">标题:</label>
                <input type="text" name="subject" id="headline">
            </p>
            <p>
                <label for="content">内容:</label>
                <textarea name="body" rows="10" cols="50" id="content"></textarea>
            </p>
        </div>
        <p>
            <input type="submit" name="submit" value="提交">
        </p>
    </form>
    <?php echo "</div>"; ?>
    <?php
}
require ("footer.php");
?>
