<?php
    session_start();
    require ("config.php");
    $link = mysqli_connect($servername, $username, $password, $dbname);
    if(isset($_SESSION['USERNAME'])== FALSE){
    header("Location:".$config_basedir);
    }
    if($_POST['submit']){
        $sql = "INSERT INTO entries(cat_id,dateposted,subject,body)
                VALUES (".$_POST['cat'].",NOW(),'".$_POST['subject']."','".$_POST['body']."');";
        mysqli_query($link,$sql);
        header("Location:".$config_basedir);

    }else{
        require ("header.php");
    }
?>
<h1>添加新文章</h1>
<form action="<?php echo $_SCRIPT_NAME?>" method="post">
   <p>
    <label for="cat">分类</label>
    <select name="cat" id="cat">
        <?php
            $catsql = "SELECT * FROM categories";
            $catres = mysqli_query($link,$catsql);
            while ($catrow = mysqli_fetch_assoc($catres)){
                echo "<option value='".$catrow['id']."'>".$catrow['cat']."</option>";
            }
        ?>
    </select>
   </p>
    <p>
    <label for="subject">文章名字</label>
        <input type="text" name="subject" id="subject">
    </p>
    <p>
        <label for="body">文章内容</label>
        <textarea name="body" id="body" rows="10" cols="50"></textarea>
    </p>
    <p>
        <input type="submit" name="submit" value="添加">
    </p>

</form>
<?php
 require ("footer.php");
?>