<?php
require ("header.php");
    $mysql = "SELECT entries.*,categories.cat 
          FROM entries,categories
          WHERE entries.cat_id = categories.id
          ORDER BY dateposted DESC 
          LIMIT 1;";
    $result = mysqli_query($link, $mysql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) == 0)
    {
        echo "0结果";
    }
    else
    {
            echo "<h2><a href='viewentry.php?id=".$row['id']."'>".$row['subject']."</a></h2><br/> ";
            echo "<i>分类:<a href='viewcat.php?id=".$row['cat_id']."'>".$row['cat']."</a>-发表于". date("Y-m-d H:i:s", strtotime($row['dateposted']))."</i>";
            if(isset($_SESSION['USERNAME']) == TRUE){
                echo  "[<a href='updateentry.php?id=".$row['id']."'>编辑</a>]";
            }
            echo "<p>";
            echo nl2br($row['body']);
            echo "</p>";
    }

        //添加评论概要
        echo "<p>";
        $commsql = "SELECT *
                    FROM comments
                    WHERE blog_id =" . $row['id'] ."
                    ORDER BY dateposted;
                    ";
        $commresult = mysqli_query($link,$commsql);
        $numrows_comm = mysqli_num_rows($commresult);
        if($numrows_comm==0)
        {
            echo  "<p>还没有评论，快来添加吧~</p>";
        }
        else {
            echo "<strong>" . $numrows_comm . "</strong> 条评论:<br/> ";
            $i = 1;
            while ($commrow = mysqli_fetch_assoc($commresult)) {
                echo "<a href='viewentry.php?id=".$row['id']."#comment".$i."'>[".$commrow['name']."]:".$commrow['comment']."</a><br/>";
                $i++;
            }
        }

        //显示以前的文章
        echo "</p>";
        $preval = "SELECT entries.*,categories.cat 
          FROM entries,categories
          WHERE entries.cat_id = categories.id
          ORDER BY dateposted DESC 
          LIMIT 1, 5;
          ";
        $prevalresult = mysqli_query($link,$preval);
        $numrows_prev = mysqli_num_rows($prevalresult);
        if($numrows_prev == 0)
        {
            echo "<p>没有之前的文章。</p>";
        }
        else{
            echo "<ul>";
            while($prevrow = mysqli_fetch_assoc($prevalresult)){
                echo "<li><a href='viewentry.php?id=".$prevrow['id']."'>".$prevrow['subject']."</a></li>";
            }
        }
        echo "</ul>";
require ("footer.php")
?>