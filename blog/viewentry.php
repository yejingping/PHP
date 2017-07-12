<?php
    //验证
    require("config.php");
    if (isset($_GET['id']) == TRUE){
        if(is_numeric($_GET['id']) == FALSE){
            header("Location".$config_basedir);
        }else{
            $validentry = $_GET['id'];
        }
    }
    else{
        $validentry = 0;
        echo '没有收到值.';
    }

    //提交表单
    if ($_POST['submit']){
        $link = mysqli_connect($servername, $username, $password, $dbname);
        if (!$link) {
            die("连接失败: " . mysqli_connect_error());
        }
        $sql = "INSERT INTO comments(blog_id,dateposted,name,comment)
                VALUES (".$validentry.",
                            NOW(),
                            '".$_POST['name']."',
                            '".$_POST['comment']."');"
                ;
        mysqli_query($link,$sql);
        header("Location:".$config_basedir."/viewentry.php?id=".$validentry);
    }else{
        require ("header.php");
    }


    //显示文章
    if($validentry == 0){
        $sql = "SELECT entries.*,categories.cat 
          FROM entries,categories
          WHERE entries.cat_id = categories.id
          ORDER BY dateposted DESC 
          LIMIT 1;";
    }else{
        $sql = "SELECT entries.*,categories.cat 
          FROM entries,categories
          WHERE entries.cat_id = categories.id AND entries.id = ". $validentry."
          ORDER BY dateposted DESC 
          LIMIT 1;";
    }
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) == 0)
    {
        echo "0结果";
    }
    else
    {
    echo "<h2>".$row['subject']."</h2><br/>";
    echo "<i>分类:<a href='viewcat.php?id=" . $row['cat_id'] . "'>" . $row['cat'] . "</a>-发表于" . date("Y-m-d H:i:s", strtotime($row['dateposted'])) . "</i>";
        if(isset($_SESSION['USERNAME']) == TRUE){
            echo  "[<a href='updateentry.php?id=".$row['id']."'>编辑</a>]";
        }
    echo "<p>";
    echo nl2br($row['body']);
    echo "</p>";
}

    //显示博客的评论
    $commsql = "SELECT *
                FROM comments
                WHERE blog_id = ".$validentry."
                ORDER BY dateposted DESC
                ";
    $commresult = mysqli_query($link,$commsql);
    $numrows_comm = mysqli_num_rows($commresult);
    if($numrows_comm==0)
    {
    echo  "<p>还没有评论，快来添加吧~</p>";
    }
    else {
        $i = 1;
        while ($commrow = mysqli_fetch_assoc($commresult)) {
            echo "<a name = 'comment".$i."'>";
            echo "<h3>评论由  <i>".$commrow['name']."</i> 发表于 ".date("Y-m-d H:i:s",strtotime($commrow['dateposted']))."</h3>";
        echo $commrow['comment'];
        $i++;
    }
}
?>

<!--添加评论-->
<form action="<?php echo $SCRIPT_NAME."?id=".$validentry;?>" method="post">
    <fieldset>
        <legend>留言板</legend>
        <p>
            <label for="name">昵称：</label>
            <input type="text" name="name" id="name">
        </p>
        <p>
            <label for="comment">评论：</label>
            <textarea name="comment" id="comment" rows="10" cols="50"></textarea>
        </p>
        <p>
            <input type="submit" name="submit" value="评论" id="submit">
        </p>
    </fieldset>

    <?php
    require ("footer.php");
    ?>

