<?
session_start();

    unset($_COOKIE['user']);
    unset($_COOKIE['path']);
    setcookie('user', null, -1, '/');
    setcookie('path', null, -1, '/');

$_SESSION["user"] = " ";
$_SESSION["path"] = " ";

setcookie("user", "", time() - 3600);
setcookie("user", "", time() - 3600);

session_destroy();



header("location:http://files.santa.lt");


?>