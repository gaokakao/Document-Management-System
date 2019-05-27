<?

$pavadinimas = $_POST['pavadinimas'];
$adresas = $_POST['adresas'];

if (isset($_POST['submit']))
{
	$error = '';
	if ($pavadinimas == '')
	{
		$error .= 'Neįvestas pavadinimas<br>';
		$errors['pavadinimas'] = 1;
	}

	if (strlen($error) == 0)
	{
		$query = "INSERT INTO objektai (pavadinimas, adresas) VALUES ('".$pavadinimas."', '".$adresas."')";
		$database->Query($query);
		unset($_SESSION['action']);

		header('Location: ./index.php');
		ob_clean();
		exit();
	}
}

if (isset($error))
{
	?>
	<span style="color: #FF0000; font-weight: bold;"><?= $error; ?></span>
	<br>
	<?
}
?>

<table width="450" cellpadding="4" cellspacing="1" bgcolor="#AAAAAA">
<form name="objektai" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
<input type="hidden" name="submit" value="1">
<tr bgcolor="#DDDDDD">
	<td colspan="2"><b>Naujas struktūrinis objektas</b></td>
</tr>
<tr bgcolor="#FFFFFF">
	<td width="150" align="right" class="list-row">
		<span <? if ($errors['pavadinimas'] == 1) echo 'style="color: #FF0000"';?>>
			Pavadinimas:
		</span>
	</td>
	<td width="350" class="list-cell">
		<input type="text" size="50" maxlength="250" name="pavadinimas" value="<?= $pavadinimas; ?>" onkeypress="validate_alpha(this);">
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right" class="list-row">
		Adresas:
	</td>
	<td class="list-cell">
		<input type="text" size="50" maxlength="250" name="adresas" value="<?= $adresas; ?>" onkeypress="validate_alpha(this);">
	</td>
</tr>
<tr bgcolor="#DDDDDD">
	<td colspan="2" align="center">
		<input type="button" class="button" value="Išvalyti" onclick="resetForm();">
		&nbsp;&nbsp;
		<input type="submit" class="button" value="Įvesti">
	</td>
</tr>
</tr>
</form>
</table>

<script>
function resetForm()
{
	document.objektai.pavadinimas.value = '';
	document.objektai.adresas.value = '';
}
document.objektai.pavadinimas.focus();
</script>