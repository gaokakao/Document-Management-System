<?
session_start();
if (isset($_SESSION['session']))
{
	session_destroy();
	header('Location: ./end.php');
}
else
{
	session_destroy();
	require_once('definitions.php');
?>

<html>

<head>
<title><?= PAGE_TITLE ?></title>
<link rel="stylesheet" type="text/css" href="style/style.css" />
<meta http-equiv="content-type" content="text/html; charset=<?= PAGE_CHARSET ?>">
</head>

<body onload="window.close();">

<table width="100%" height="100%" cellpadding="0" cellspacing="0">
<tr valign="middle" align="center">
	<td>
		<form name="forma" action="./index.php" method="POST">
			<input type="submit" name="reenter" value="Jungtis iš naujo" autofocus>
		</form>
	</td>
</tr>
</table>

</body>

</html>

<?
}
?>