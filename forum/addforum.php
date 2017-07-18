<?php
session_start();
require ("config.php");
require ("function.php");

//添加版块--fine!
$link = mysqli_connect($servername, $username, $password, $dbname);
if (!$link) {
    die("连接失败: " . mysqli_connect_error());
}

if(isset($_SESSION['ADMIN']) == FALSE){
    header("Location:".$config_basedir."/admin.php?ref=add");
}

if($_POST['submit']){
    $topicsql = "INSERT INTO forums(cat_id,name,description)
                  VALUES (".$_POST['cat'].",
                          '".$_POST['name']."',
                          '".$_POST['description']."');
                          ";
    mysqli_query($link,$topicsql);
    header("Location:".$config_basedir);
}else{
    require ("header.php");

?>
<form action="<?php echo pf_script_with_get($SCRIPT_NAME);?>" method="post">
    <div class="fill">
        <h1>添加新的版块</h1>
        <div id="fill_t">
        <?php
        if($validforum == 0) {
            $forumssql = "SELECT * FROM categories ORDER BY name";
            $forumsresult = mysqli_query($link, $forumssql);
            ?>
            <p>
                <label for="forum">分类:</label>
                <select name="cat" id="forum">
                    <?php
                    while ($forumsrow = mysqli_fetch_assoc($forumsresult)) {
                        echo "<option value='" . $forumsrow['id'] . "'>" . $forumsrow['name'] . "</option>";
                    }
                    ?>
                </select>
            </p>
            <?php
        }
        ?><p>
            <label for="title">名称:</label>
            <input type="text" name="name" id="name"></p>
            <p><label for="desc">详细描述:</label>
            <textarea name="description" rows="10" cols="50" ></textarea ><br/></p>
        </div>
            <input type="submit" name="submit" value="添加新版块">

    </div>
</form>
<?php
}
require ("footer.php");
    ?>