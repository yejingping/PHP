</div>
<div id="footer">
    &copy;2010-<?php echo date("Y");?><br/>
    <?php echo $config_admin;?><br/>
    <?php
        if (isset($_SESSION['ADMIN']) == TRUE){
            echo "<a href='adminlogout.php'>退出</a>";
        }else{
            echo "<a href='admin.php' style='color:red;'>管理员登录</a>";
        }

    ?>
</div>
</body>
</html>