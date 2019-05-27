<?

if (isset($_POST['submit']))
{
	$slaptazodis = $_POST['slaptazodis'];
	$eilutes = $_POST['eilutes'];
	$excel = $_POST['excel'];

	$error = '';
	if (($slaptazodis == '') or (strlen($slaptazodis) < 4))
	{
		$error .= 'Neįvestas slaptažodis arba slaptažodis per trumpas<br>';
		$errors['slaptazodis'] = 1;
	}

	if (strlen($error) == 0)
	{
		$query = "UPDATE asmenys SET slaptazodis = '".$slaptazodis."', eilutes = '".$eilutes."', excel = '".$excel."' WHERE asmens_id = ".$_SESSION['asmens_id'];
		$database->Query($query);
		$_SESSION['submited'] = '1';
		$_SESSION['excel'] = $excel;
		$_SESSION['eilutes'] = $eilutes;
		$_SESSION['puslapis'] = 1;
		unset($_SESSION['action']);
		unset($_SESSION['id']);

		header('Location: ./index.php');
		ob_clean();
		exit();
	}
}
else
{
	$query = "SELECT * FROM asmenys WHERE asmens_id = ".$_SESSION['asmens_id'];
	$row = $database->QueryAssoc($query);

	$slaptazodis = $row['slaptazodis'];
	$eilutes = $row['eilutes'];
	$excel = $row['excel'];
}

if (isset($error))
{
	?>
	<span style="color: #FF0000; font-weight: bold;"><?= $error; ?></span>
	<br>
	<?
}
if (isset($_SESSION['submited']))
{
	?>
	<span style="color: #FF0000; font-weight: bold;">Nustatymai pakeisti</span>
	<br><br>
	<?
	unset($_SESSION['submited']);
}
?>

<table width="450" cellpadding="4" cellspacing="1" bgcolor="#AAAAAA">
<form name="vartotojai" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
<input type="hidden" name="submit" value="1">
<tr bgcolor="#DDDDDD">
	<td colspan="2"><b>Nustatymai</b></td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		<span <? if ($errors['eilutes'] == 1) echo 'style="color: #FF0000"';?>>
			Sutarčių eilučių skaičius per puslapį:
		</span>
	</td>
	<td width="300">
		<select name="eilutes">
			<?
				$lines = array('10', '25', '50', '100', '200', '500', '1000');

				foreach ($lines as $line)
				{
					?>
					<option <? if ($line == $eilutes) echo 'selected'; ?> value="<?= $line; ?>"><?= $line; ?></option>
					<?
				}
			?>
		</select>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		<span <? if ($errors['slaptazodis'] == 1) echo 'style="color: #FF0000"';?>>
			Slaptažodis:
		</span>
	</td>
	<td>
		<input type="password" size="50" maxlength="250" name="slaptazodis" value="<?= $slaptazodis; ?>">
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		<span <? if ($errors['excel'] == 1) echo 'style="color: #FF0000"';?>>
			Eksportuoti į Excel:
		</span>
	</td>
	<td>
		<select name="excel">
			<option value="main" <? if ($excel == 'main') echo 'selected'; ?>>Tik sutartis</option>
			<option value="all" <? if ($excel == 'all') echo 'selected'; ?>>Sutartis su priedais</option>
		</select>
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
	document.nustatymai.eilutes.selectedIndex = 0;
	document.nustatymai.slaptazodis.value = '';
}
document.vartotojai.slaptazodis.focus();
</script>