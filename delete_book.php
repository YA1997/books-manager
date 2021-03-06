<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>删除结果</title>
</head>

<body>
    <h1>删除结果</h1>
    <?php
    session_start();
    if (isset($_SESSION['valid_user'])) {
        $searchtype = $_POST['searchtype'];
        $searchterm = trim($_POST['searchterm']);

        if (!$searchtype || !$searchterm) {
            echo '<p>删除条件有误</p>';
            exit;
        }

        switch ($searchtype) {
            case 'Title':
            case 'Author':
            case 'ISBN':
                break;
            default:
                echo '<p>删除类型有误</p>';
                exit;
        }

        // 连接数据库
        @$db = new mysqli('localhost', 'root', 'root', 'books');
        if (mysqli_connect_errno()) {
            echo '<p>无法连接数据库，请重试</p>';
            exit;
        }

        mysqli_query($db, 'set names utf8');  //设置数据库字符集为utf8
        $query = "DELETE FROM books
                WHERE $searchtype= ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $searchterm);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<p>$searchtype 为 $searchterm 的图书已经删除完毕</p>";
        } else {
            echo "<p>图书删除失败，请重试。</p>";
            echo "当前登陆用户为：".$_SESSION['valid_user'];
        }

        $db->close();          //断开数据库连接
    } else {
        echo '<p>你还未登陆，请先登录。</p>';
        echo '<a href="index.html">前去登陆</a>';
    }


    ?>
    <p><a href="javascript:;" onclick="window.history.back()">返回</a></p>

</body>

</html>