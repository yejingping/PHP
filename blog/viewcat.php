<?php
require ("header.php");
//验证
if (isset($_GET['id']) == TRUE){
    if(is_numeric($_GET['id']) == FALSE){
        header("Location".$config_basedir."/viewcat.php");
    }else{
        $validcat = $_GET['id'];
    }
}
else{
    $validcat = 0;
}

//分类浏览
$sql = "SELECT * FROM categories";
$result = mysqli_query($link,$sql);

while($row = mysqli_fetch_assoc($result)){
    if($validcat == $row['id']){
        echo "<strong>".$row['cat']."</strong></br>";

        $entriessql = "SELECT * 
                       FROM entries 
                       WHERE cat_id =".$validcat."
                       ORDER BY dateposted DESC;
                       ";
        $entriesres = mysqli_query($link,$entriessql);
        $numrows_entries = mysqli_num_rows($entriesres);
        echo "<ul>";
        if($numrows_entries == 0){
            echo "<li>无分类！</li>";
        }else{
            while ($entriesrow = mysqli_fetch_assoc($entriesres)){
                echo "<li>".date("Y-m-d",strtotime($entriesrow['dateposted']))."-<a href='viewentry.php?id=".$entriesrow['id']."'>".$entriesrow['subject']."</a></li>";
            }
        }
        echo "</ul>";
    }else{
        echo "<a href='viewcat.php?id = ".$row['id']."'>".$row['cat']."</a></br/>";
    }

}
require ("footer.php");
?>