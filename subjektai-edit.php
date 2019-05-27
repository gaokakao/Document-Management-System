<?

if (isset($_POST['submit']))
{
	$pavadinimas = $_POST['pavadinimas'];
	$adresas = $_POST['adresas'];
	$kodas = $_POST['kodas'];

	$error = '';
	if ($pavadinimas == '')
	{
		$error .= 'Neįvestas pavadinimas<br>';
		$errors['pavadinimas'] = 1;
	}

	if (strlen($error) == 0)
	{
		$query = "UPDATE subjektai SET pavadinimas = '".$pavadinimas."', adresas = '".$adresas."', kodas = '".$kodas."' WHERE subjekto_id = ".$_SESSION['id'];
		$database->Query($query);
		unset($_SESSION['action']);
		unset($_SESSION['id']);

		header('Location: ./index.php');
		ob_clean();
		exit();
	}
}
else
{
	$query = "SELECT * FROM subjektai WHERE subjekto_id = ".$_SESSION['id'];
	$row = $database->QueryAssoc($query);

	$pavadinimas = $row['pavadinimas'];
	$adresas = $row['adresas'];
	$kodas = $row['kodas'];
}

if (isset($error))
{
	?>
	<span style="color: #FF0000; font-weight: bold;"><?= $error; ?></span>
	<br>
	<?
}
?>

<table width="400" cellpadding="5" cellspacing="1" bgcolor="#AAAAAA">
<form name="subjektai" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
<input type="hidden" name="submit" value="1">
<tr bgcolor="#DDDDDD">
	<td colspan="4"><b>Subjekto informacijos keitimas</b></td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right">
		<span <? if ($errors['pavadinimas'] == 1) echo 'style="color: #FF0000"';?>>
			Pavadinimas:
		</span>
	</td>
	<td width="300"">
		<input type="text" size="50" maxlength="250" name="pavadinimas" value="<?= htmlspecialchars($pavadinimas); ?>" onkeypress="validate_alpha(this);">
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right">
		Adresas:
	</td>
	<td>
		<input type="text" size="50" maxlength="250" name="adresas" value="<?= $adresas; ?>" onkeypress="validate_alpha(this);">
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right">
		Kodas:
	</td>
	<td>
		<input type="text" size="50" maxlength="250" name="kodas" value="<?= $kodas; ?>" onkeypress="validate_number(this);">
	</td>
</tr>
<tr bgcolor="#DDDDDD">
	<td colspan="2" align="center">
		<input type="button" class="button" value="Išvalyti" onclick="resetForm();">
		&nbsp;&nbsp;
		<input type="submit" class="button" value="Įvesti">
	</td>
</tr>
</form>
</table>

<script>
function resetForm()
{
	document.subjektai.pavadinimas.value = '';
	document.subjektai.adresas.value = '';
	document.subjektai.kodas.value = '';
}
document.subjektai.pavadinimas.focus();
</script>