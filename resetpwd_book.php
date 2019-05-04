<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>修改结果</title>
</head>

<body>
    <h1>修改结果</h1>
    <?php
    $uid = trim($_POST['uid']);
    $pwd = trim($_POST['pwd']);
    $email = trim($_POST['email']);

    // 连接数据库
    @$db = new mysqli('localhost', 'root', 'root', 'books');
    if (mysqli_connect_errno()) {
        echo '<p>无法连接数据库，请重试</p>';
        exit;
    }

    mysqli_query($db, 'set names utf8'); //设置数据库字符集为utf8
    $query = "UPDATE users 
            SET pwd = ?
            WHERE uid = ? AND email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('sss', $pwd, $uid, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<p>修改密码成功！快去使用新密码登陆吧！</p>";
    } else {
        echo "<p>重置密码失败，可能原因：<br>
        1.用户名和邮箱不匹配。<br>
        2.新密码与旧密码相同。<br>
        3.该用户名或邮箱尚未注册。</p>";
        echo "<p><a href='resetpwd.html'>重新修改</a></p>";
        echo "<p><a href='register.html'>前去注册</a></p>";
    }

    $db->close();

    ?>
    <p><a href="index.html">前去登陆</a></p>

</body>

</html>