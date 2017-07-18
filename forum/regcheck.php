<?php
session_start();
require ("config.php");
$link = mysqli_connect($servername, $username, $password, $dbname);
if (!$link) {
    die("连接失败: " . mysqli_connect_error());
}

if($_POST['submit'] && $_POST['submit'] == '注册'){
    $username = $_POST['username'];
    $pwd = $_POST['password1'];
    $pwd_confirm = $_POST['password2'];

    //验证是否为空，此处应该用javascript。
    if($username  == "" || $pwd == "" || $pwd_confirm == ""){
        echo "<script>alert('请确认信息完整性！');history.go(-1);</script>";
    }else{

        //检查密码是否一致
        if($pwd = $pwd_confirm){

            $checksql = "SELECT * FROM users 
                      WHERE username='" . $_POST['username'] . "';
                     ";
            $checkresult = mysqli_query($link, $checksql);
            $checknumrows = mysqli_num_rows($checkresult);

            //检查用户名是否已经存在
            if($checknumrows == 1){
                echo "<script>alert('用户名已经存在，请使用其他的用户名！');history.go(-1);</script>";
            }else{
                $sql = "INSERT INTO users(username,password,email,verifystring,active)
                    VALUES ('" . $_POST['username'] . "',
                            '" . $_POST['password1'] . "',
                            '" . $_POST['email'] . "',
                            '" . addslashes($randomstring) . "',
                            0);
                            ";
                $result = mysqli_query($link,$sql);
             if($result){
                  for ($i = 0; $i < 6; $i++) {
                   $randomstring .= chr(mt_rand(32, 126));
                    }
//                   $verifyurl = "http://127.0.0.1/forum/verify.php";
//                    $verify = urlencode($randomstring);
//                    $verifyemail = urlencode($_POST['email']);
//                    $validusername = $_POST['username'];
//                    $to = $_POST['email'];
//                    $subject = '电影论坛用户认证';
//                    $message = '<<<_MAIL_
//                $validusername 你好,请点击下方链接来验证你的新账号：
//                $verifyurl?email = $verifyemail&verify=$verifystring
//_MAIL_;';
//                    mail($to,$subject,$message);
                    require ("header.php");
                    echo "<div style='height:300px;text-align: center;margin-top: 150px;'>";
                    echo "<h2>一个链接已经发送到您的邮箱，请打开邮箱点击链接验证。</h2>";
                    echo "</div>";
                    require ("footer.php");
                }else{
                    echo "<script>alert('系统繁忙，请稍后再试！');history.go(-1);</script>";
                }

            }
        }else{
            echo "<script>alert('两次密码不一致！请重新填写。');history.go(-1);</script>";
        }

    }
}else{
    echo "<script>alert('提交未成功，请重新注册！');history.go(-1);</script>";
}