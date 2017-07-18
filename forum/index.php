<?php
//显示有效的版块
require ("header.php");
if(isset($_SESSION['ADMIN']) == TRUE){
    echo "<p class='operation'><a href='addcat.php'><span>新增分类</span></a>";
    echo "<a href='addforum.php'><span>新增版块</span></p>";
}

//执行查询获得所有的分类
$catsql = "SELECT *  FROM categories;";
$catresult = mysqli_query($link,$catsql);


//显示所有的分类--fine!
while($catrow = mysqli_fetch_assoc($catresult)){

    echo "<p class='casub'>".$catrow['name']."";
    if($_SESSION['ADMIN']){
        echo "<a href='delete.php?func=cat&id=".$catrow['id']."'><span>-删除</span></a></p>";
    }
    //检查当前分类是否包含版块--fine!
    $forumsql = "SELECT * FROM forums WHERE cat_id = ".$catrow['id'].";";
    $forumresult = mysqli_query($link,$forumsql);
    $forumnumrows = mysqli_num_rows($forumresult);
    if ($forumnumrows == 0){
        echo "<div class='forums'>当前没有版块！</div>";
    }else{
        while($forumrow = mysqli_fetch_assoc($forumresult)){
            echo "<div class='forums'>";
            echo "<strong><a href='viewforum.php?id=".$forumrow['id']."'>【".$forumrow['name']."】</a></strong> ";
            if($_SESSION['ADMIN']){
                echo "<a href='delete.php?func=forum&id=".$forumrow['id']."&&forum=".$validforum."'>-删除</a>";
            }
            echo "<br/>".$forumrow['description']."";
            echo "</div>";
        }
    }
}
require ("footer.php");
?>