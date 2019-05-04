<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>加入新书结果</title>
</head>

<body>
    <h1>加入新书结果</h1>
    <?php
    session_start();
    if (isset($_SESSION['valid_user'])) {
        if (!isset($_POST['ISBN']) || !isset($_POST['Author']) || !isset($_POST['Title']) || !isset($_POST['Price'])) {
            echo "<p>你还未输入全部需要的信息，请重试</p>";
            exit;
        }
    
        $isbn = $_POST['ISBN'];
        $author = $_POST['Author'];
        $title = $_POST['Title'];
        $price = $_POST['Price'];
        $price = doubleval($price);
    
    
        // 连接数据库
        @$db = new mysqli('localhost', 'root', 'root', 'books');
        if (mysqli_connect_errno()) {
            echo '<p>无法连接数据库，请重试</p>';
            exit;
        }
    
        mysqli_query($db, 'set names utf8');//设置数据库字符集为utf8
        $query="INSERT INTO Books VALUES (?,?,?,?)";
        $stmt=$db->prepare($query);
        $stmt->bind_param('sssd', $isbn, $author, $title, $price);
        $stmt->execute();
    
        if($stmt->affected_rows>0){
            echo "<p>图书添加成功！</p>";
        } else{
            echo "<p>图书添加失败，请重试。</p>";
        }
        
        $db->close();
    } else {
        echo '<p>你还未登陆，请先登录。</p>';
        echo '<a href="index.html">前去登陆</a>';
    }
    


    ?>
    <p><a href="javascript:;" onclick="window.history.back()">返回</a></p>
</body>

</html>