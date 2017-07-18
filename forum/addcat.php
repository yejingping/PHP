<?php
session_start();
require ("config.php");
require ("function.php");

//判断管理员是否登录-fine!
if(isset($_SESSION['ADMIN']) == FALSE){
    header("Location:".$config_basedir."/admin.php?ref=cat");
}

//处理表单-fine!
if($_POST['submit']){
    $link = mysqli_connect($servername, $username, $password, $dbname);
    if (!$link) {
        die("连接失败: " . mysqli_connect_error());
    }

    $catsql = "INSERT INTO categories(name) VALUES('".$_POST['cat']."');";
    mysqli_query($link,$catsql);
    header("Location:".$config_basedir);
}else {
    require("header.php");


    ?>
    <form action="<?php echo pf_script_with_get($SCRIPT_NAME); ?>" method="post">
        <div class="fill">
          <h1>添加新的分类</h1>
                <input type="text" name="cat" placeholder="分类名称"><br/>
                <input type="submit" name="submit" value="添加新的分类">

        </div>
    </form>
    <?php
}
require ("footer.php");
    ?>