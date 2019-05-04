<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    $uid = trim($_POST['uid']);
    $pwd = trim($_POST['pwd']);
    // 连接数据库
    @$db = new mysqli('localhost', 'root', 'root', 'books');
    if (mysqli_connect_errno()) {
        echo '<p>无法连接数据库，请重试</p>';
        exit;
    }

    mysqli_query($db, 'set names utf8'); //设置数据库字符集为utf8
    
    //查询users表中是否有对应的用户名与密码
    $query = "SELECT * 
            FROM users
            WHERE uid=? AND pwd=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ss', $uid, $pwd);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['valid_user']=$uid;
        echo "<p>登陆成功！</p>";
        echo "<p><a href='main.html'>前往主界面</a></p>";
    } else {
        echo "<p>登陆失败，请更换用户名或密码重试。</p>";
        echo "<p><a href='javascript:;' onclick='window.history.back()'>返回</a></p>";
    }
    $db->close();
    ?>
</body>

</html>