<?php
require ("header.php");
?>
<form action="regcheck.php" method="post">
    <div class="fill" id="fill">
        <h1>创建一个账号</h1>
        <p>为了更好的访问电影论坛，请准确填写以下信息。</p>
        <input type="text" name="username" id="username" placeholder="用户名"><br/>
        <input type="password" name="password1" id="password1" placeholder="密码"><br/>
        <input type="password" name="password2" id="password2" placeholder="确认密码"><br/>
        <input type="email" name="email" id="email" placeholder="电子邮箱"><br/>
        <input type="submit" name="submit" id="submit" value="注册"><br/>
    </div>
</form>
<?php
    require ("footer.php");
?>
