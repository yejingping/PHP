<?php
require ("config.php");

//viewforum.php中的57行的？id=$topicrow['topicid']，版块的编号
if (isset($_GET['id']) == TRUE){
    if(is_numeric($_GET['id']) == FALSE){
        header("Location".$config_basedir);
    }else{
        $validtopic = $_GET['id'];
    }
}
else {
    $validtopic = 0;
    echo '没有收到值.';
}
require ("header.php");

//建立足迹
$topicsql= "SELECT topics.subject,topics.forum_id,forums.name
            FROM topics,forums
            WHERE topics.forum_id = forums.id AND topics.id = ".$validtopic.";
            ";
$topicresult=mysqli_query($link,$topicsql);
//24

$topicrow = mysqli_fetch_assoc($topicresult);
echo "<div id='view'>";
echo "<a href='index.php'>".$config_forumsname."</a>&gt;<a href='viewforum.php?id=".$topicrow['forum_id']."'>".$topicrow['name']."</a><br><br>";
echo "<h2 style='text-align: center'>".$topicrow['subject']."</h2>";
//显示某话题的所有帖子
$threadsql = "SELECT messages.*,users.username
              FROM messages,users
              WHERE messages.user_id = users.id AND messages.topic_id = ".$validtopic."
              ORDER BY messages.date;
              ";
$threadresult = mysqli_query($link,$threadsql);
echo "<table class='tableCss' id='special'>";
echo "<tr>";
echo "<th>发言人</th>";
echo "<th>标题</th>";
echo "<th>内容</th>";
echo "<th></th>";
echo "</tr>";
//依次显示每一个帖子
//43
while($threadrow=mysqli_fetch_assoc($threadresult)){
    echo "<tr><td><strong><i>".$threadrow['username']."</i> 发表于".date("Y-m-d H:i:s", strtotime($threadrow['date']))."</strong></td>";
    echo "<td>".$threadrow['subject']."</td>";
    echo "<td>".$threadrow['body']."</td>";
    echo "<td><a href='reply.php?id=".$validtopic."'>回复</a></td></tr>";
}
echo "</table>";
echo "</div>";
require ("footer.php");

?>

