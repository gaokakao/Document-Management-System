<?

require_once('./definitions.php');

?>

<html>

<head>
<title><?= PAGE_TITLE ?></title>
<link rel="stylesheet" type="text/css" href="style/other/style.css" />
<meta http-equiv="content-type" content="text/html; charset=<?= PAGE_CHARSET ?>">

<script>
function popUpWindow()
{
	window.open("./authenticate.php", null, "width=100,height=710,fullscreen=no,status=no,toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=yes");
	//window. close();
}
</script>

</head>

<body class="password-page" onload="popUpWindow();">

<table width="100%" height="100%" cellpadding="0" cellspacing="0">
<tr>
	<td height="48%">&nbsp;</td>
</tr>
<tr align="center">
	<td>Galite uždaryti šį langą</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr align="center">
	<td>
		<input type="button" value="Jungtis iš naujo" onclick="popUpWindow();" class="button">
		&nbsp;&nbsp;&nbsp;
		<input type="button" value="Uždaryti" onclick="window.close();" class="button">
	</td>
</tr>
<tr>
	<td height="48%">&nbsp;</td>
</tr>
</table>

</body>

</html>