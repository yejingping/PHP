<?php
session_start();
require("config.php");

//从index.php传过来的id值
if (isset($_GET['id']) == TRUE){
    if(is_numeric($_GET['id']) == FALSE){
        header("Location".$config_basedir);
    }else{
        $validforum = $_GET['id'];
    }
}
else {
    $validforum = 0;
    echo '没有收到值.';
}
require ("header.php");

//显示基本信息：当前版块名称与浏览足迹信息

$forumsql = "SELECT * FROM forums WHERE id =".$validforum.";";
$forumresult =mysqli_query($link,$forumsql);
$forumrow = mysqli_fetch_assoc($forumresult);

echo "<div id='view'><a href='index.php'>".$config_forumsname."</a>";
echo "<a href='newtopic.php?id=".$validforum."'  id='newtopic'>发布新话题</a>";

//帖子具体内容：显示最新日期的帖子
//sql：fine!
$topicsql = "SELECT MAX(messages.date) AS maxdate,topics.id AS topicid,topics.*,users.*
             FROM messages,topics,users
             WHERE messages.topic_id=topics.id AND topics.user_id=users.id AND topics.forum_id=".$validforum."
             GROUP BY messages.topic_id
             ORDER BY maxdate DESC;
             ";
$topicresult = mysqli_query($link,$topicsql);
$topicnumrows = mysqli_num_rows($topicresult);
if($topicnumrows == 0){
    echo "<table class='tableCss'><tr><td>没有话题！</td></tr></table>";
}else{
    echo "<table class='tableCss'>";
    echo "<caption>".$forumrow['name']."</caption>";
    echo "<tr>";
    echo "<th>话题</th>";
    echo "<th>回复</th>";
    echo "<th>发言人</th>";
    echo "<th>发表日期</th>";
    echo "</tr>";
    //查询当前帖子数目
    //topicid即是30行的topics.id，即版块的编号
    while($topicrow = mysqli_fetch_assoc($topicresult)){
        $msgsql = "SELECT id FROM messages WHERE topic_id=".$topicrow['topicid'].";";
        $msgresult = mysqli_query($link,$msgsql);
        $msgnumrows = mysqli_num_rows($msgresult);
    //显示记录
        echo "<tr>";
        echo "<td>";
        echo "<strong><a href='viewmessages.php?id=".$topicrow['topicid']."'>".$topicrow['subject']."</a></strong>";
        if($_SESSION['ADMIN']){
            echo "<a href='delete.php?func=thread&id=".$topicrow['topicid']."&forum=".$validforum."'>-删除</a>";}
            echo "</td>";
        echo "<td>".$msgnumrows."</td>";
        echo "<td>".$topicrow['username']."</td>";
        echo "<td>".date("Y-m-d H:i:s", strtotime($topicrow['date']))."</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    require ("footer.php");
}

?>