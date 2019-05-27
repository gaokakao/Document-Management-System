<?

$raktas = $_SESSION['search'];

if (isset($_POST['submit']))
{
	$_SESSION['search'] = $_POST['raktas'];
	$_SESSION['puslapis'] = 0;
	unset($_SESSION['action']);

	header('Location: ./index.php');
	ob_clean();
	exit();
}

if (isset($error))
{
	?>
	<span style="color: #FF0000; font-weight: bold;"><?= $error; ?></span>
	<br>
	<?
}
?>

<table width="470" cellpadding="4" cellspacing="1" bgcolor="#AAAAAA">
<form name="paieska" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
<input type="hidden" name="submit" value="1">
<tr bgcolor="#DDDDDD">
	<td colspan="4"><b>Greita paieška</b></td>
</tr>
<tr bgcolor="#FFFFFF">
	<td width="99%" align="right">
		Ieškomas žodis ar fragmentas:
	</td>
	<td colspan="3">
		<input type="text" size="50" maxlength="250" name="raktas" value="<?= $raktas; ?>">
	</td>
</tr>
<tr bgcolor="#DDDDDD">
	<td colspan="4" align="center">
		<input type="button" class="button" value="Išvalyti" onclick="document.paieska.raktas.value = '';">
		&nbsp;&nbsp;
		<input type="submit" class="button" value="Įvesti">
	</td>
</tr>
</form>
</table>

<script>
	document.paieska.raktas.focus();
</script>
