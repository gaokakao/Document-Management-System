<?
require_once('./header.php');
require_once('./definitions.php');
?>

<html>

<head>
<title><?= PAGE_TITLE ?></title>
<link rel="stylesheet" type="text/css" href="style/style.css" />
<meta http-equiv="content-type" content="text/html; charset=<?= PAGE_CHARSET ?>">
</head>

<body>

<table width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr><td height="48%">&nbsp;</td></tr>
	<tr align="center"><td>Neįmanoma prisijungti prie duomenų bazės!</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr align="center"><td><input type="button" onclick="window.location.href='./index.php';" value="Bandyti dar kartą"></td></tr>
	<tr><td height="48%">&nbsp;</td></tr>
</table>

</body>

</html>