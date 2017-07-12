<!--添加评论-->
<?php
    session_start();
    require ("config.php");
    $link = mysqli_connect($servername, $username, $password, $dbname);

    if(isset($_SESSION['USERNAME'])== FALSE){
        header("Location:".$config_basedir);
    }
    if (isset($_GET['id']) == TRUE){
        if(is_numeric($_GET['id']) == FALSE){
            header("Location:".$config_basedir);
        }
        else{
            $validentry = $_GET['id'];
        }
    }
    else{
        $validentry = 0;
    }

    //提交按钮
    if($_POST['submit']){
        $sql = "UPDATE entries
                SET cat_id='".$_POST['cat']."',
                    subject='".$_POST['subject']."',
                    body='".$_POST['body']."'
                WHERE id=".$validentry.";
                ";
        mysqli_query($link,$sql);
        header("Location:".$config_basedir."/viewentry.php?id=".$validentry);
    }else{
        require ("header.php");
        $fillsql = "SELECT * FROM entries WHERE id=".$validentry.";";
        $fillres = mysqli_query($link,$fillsql);
        $fillrow = mysqli_fetch_assoc($fillres);
    }
    ?>
    <form action="<?php echo $SCRIPT_NAME."?id=".$validentry; ?>" method = "post">

        <p>
            <label for="cat">分类目录</label>
            <select name="cat" id="cat">
                <?php
                $catsql = "SELECT * FROM categories";
                $catres = mysqli_query($link,$catsql);
                while ($catrow = mysqli_fetch_assoc($catres)) {
                    echo "<option value='" . $catrow['id'] . "'";
                    if ($catrow['id'] == $fillrow['cat_id']) {
                        echo " selected";
                    }
                    echo " '>" . $catrow['cat'] . "</option>";
                }
                ?>
            </select>
        </p>
        <p>
            <label for="subject">文章名字</label>
            <input type="text" name="subject" id="subject" value="<?php echo $fillrow['subject']?>">
        </p>
        <p>
            <label for="body">文章内容</label>
            <textarea name="body" id="body" rows="10" cols="50">
                <?php echo $fillrow['body']?>
            </textarea>
        </p>
        <p>
            <input type="submit" name="submit" value="更新" id="submit">
        </p>
    </form>

<?php
require ("footer.php");
?>