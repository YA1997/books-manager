<?php
session_start();
$data=$_POST['flag'];
if ($data=='checklog') {
    if (isset($_SESSION['valid_user'])) {
        $username = $_SESSION['valid_user'];
        echo $username;
    } else{
        echo 'notlogged';
    }
} else if($data=='logout'){
    unset($_SESSION['valid_user']);
    session_destroy();
}
