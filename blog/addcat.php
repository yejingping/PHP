<?php

    session_start();
    require ("config.php");
    $link = mysqli_connect($servername, $username, $password, $dbname);
    if(isset($_SESSION['USERNAME'])== FALSE){
        header("Location:".$config_basedir);
    }

    if($_POST['submit']){
        $sql = "INSERT INTO categories(cat)
                VALUES ('".$_POST['cat']."');
                ";
        mysqli_query($link,$sql);
        header("Location:".$config_basedir."viewcat.php");

    }else{
        require ("header.php");
    }


?>
<h1>添加新的分类</h1>
<form action="<?php echo $SCRIPT_NAME?>" method="post">
    <p>
        <label for="cat">新的分类</label>
        <input type="text" id="cat" name="cat">
    </p>
    <p>
        <label> </label>
        <input type="submit" name="submit" value="添加" id="submit">
    </p>
</form>
<?php

require ("footer.php");
?>