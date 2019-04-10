<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>更改结果</title>
</head>

<body>
    <h1>更改结果</h1>
    <?php
    $searchtype = $_POST['searchtype'];
    $searchterm = trim($_POST['searchterm']);
    $updatetype = $_POST['updatetype'];
    $updateterm = trim($_POST['updateterm']);

    if (!$searchtype || !$searchterm) {
        echo '<p>目标图书有误</p>';
        exit;
    }

    if (!$updatetype || !$updateterm) {
        echo '<p>更新内容有误</p>';
        exit;
    }
    switch ($searchtype) {
        case 'Title':
        case 'Author':
        case 'ISBN':
            break;
        default:
            echo '<p>搜索类型有误</p>';
            exit;
    }
    switch ($updatetype) {
        case 'Title':
        case 'Author':
        case 'ISBN':
        case 'Price':
            break;
        default:
            echo '<p>更新内容有误</p>';
            exit;
    }

    // 连接数据库
    @$db = new mysqli('localhost', 'root', 'root', 'books');
    if (mysqli_connect_errno()) {
        echo '<p>无法连接数据库，请重试</p>';
        exit;
    }

    mysqli_query($db, 'set names utf8');//设置数据库字符集为utf8
    $query = "UPDATE books
            SET $updatetype= ?
            WHERE $searchtype= ?";
    $stmt = $db->prepare($query);
    if ($updatetype == 'Price') {
        $updateterm=doubleval($updateterm);
        $stmt->bind_param('ds', $updateterm, $searchterm);
    } else {
        $stmt->bind_param('ss', $updateterm, $searchterm);
    }


    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<p>图书修改成功！</p><p>以下是修改后的信息：</p>";
        $query = "SELECT ISBN, Author, Title, Price
                FROM books
                WHERE $searchtype= ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $searchterm);
        $stmt->execute();
        $stmt->store_result();

        $stmt->bind_result($isbn, $author, $title, $price);
        echo "<p><strong>共修改" . $stmt->num_rows . "本书</strong></p>";

        while ($stmt->fetch()) {
            echo "<p><strong>书名：" . $title . "</strong>";
            echo "<br>作者：" . $author;
            echo "<br>ISBN：" . $isbn;
            echo "<br>价格：" . number_format($price, 2) . "</p>";
        }
        $stmt->free_result();
    } else {
        echo "<p>图书修改失败，请重试。</p>";
    }


    $db->close();

    ?>
    <p><a href="javascript:;" onclick="window.history.back()">返回</a></p>

</body>

</html>