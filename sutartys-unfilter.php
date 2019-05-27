<?

$_SESSION['puslapis'] = 0;
unset($_SESSION['filter']);
unset($_SESSION['search']);
unset($_SESSION['action']);
header('Location: ./index.php');
ob_clean();
exit();

?>