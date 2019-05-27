<?
session_start();

    unset($_COOKIE['user']);
    unset($_COOKIE['ptivate']);
    unset($_COOKIE['shared']);
    setcookie('user', null, -1, '/');
    setcookie('ptivate', null, -1, '/');
    setcookie('shared', null, -1, '/');

$_SESSION["user"] = " ";
$_SESSION["ptivate"] = " ";
$_SESSION["shared"] = " ";

setcookie("user", "", time() - 3600);
setcookie("ptivate", "", time() - 3600);
setcookie("shared", "", time() - 3600);

session_destroy();



header("location:https://files.santa.lt");


?>