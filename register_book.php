<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册结果</title>
</head>

<body>
    <h1>注册结果</h1>
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

    mysqli_query($db, 'set names utf8');//设置数据库字符集为utf8
    $query="INSERT INTO users VALUES (?,?,?)";
    $stmt=$db->prepare($query);
    $stmt->bind_param('sss', $uid, $pwd, $email);
    $stmt->execute();

    if($stmt->affected_rows>0){
        echo "<p>注册成功！</p>";
    } else{
        echo "<p>注册失败，请更换用户名或邮箱重试。</p>";
    }

    $db->close();

    ?>
    <p><a href="index.html">前去登陆</a></p>
    <p><a href="register.html">返回注册</a></p>
</body>

</html>