<?

if (isset($_POST['submit']))
{
	$vardas = $_POST['vardas'];
	$pavarde = $_POST['pavarde'];
	$pareigos = $_POST['pareigos'];
	$vartotojo_vardas = $_POST['vartotojo_vardas'];
	$slaptazodis = $_POST['slaptazodis'];
	$lygis = $_POST['lygis'];
	$email = $_POST['email'];

	$error = '';
	if ($vardas == '')
	{
		$error .= 'Neįvestas vardas<br>';
		$errors['vardas'] = 1;
	}
	if ($pavarde == '')
	{
		$error .= 'Neįvesta pavardė<br>';
		$errors['pavarde'] = 1;
	}
	if ($pareigos == '')
	{
		$error .= 'Neįvestos pareigos<br>';
		$errors['pareigos'] = 1;
	}
	if ($lygis == 'NULL')
	{
		$error .= 'Nepasirinktas vartotojo tipas<br>';
		$errors['tipas'] = 1;
	}
	else if ($lygis != 'none')
	{
		if ($email == '')
		{
			$error .= 'Neįvestas elektroninio pašto adresas<br>';
			$errors['email'] = 1;
		}
		if ((strpos($email, '@') === false) or (strpos($email, '.') === false))
		{
			$error .= 'Neteisingas elektronio pašto adresas<br>';
			$errors['email'] = 1;
		}
		if ($vartotojo_vardas == '')
		{
			$error .= 'Neįvestas vartotojo vardas<br>';
			$errors['vartotojo_vardas'] = 1;
		}
		else
		{
			$query = "SELECT * FROM asmenys WHERE vartotojo_vardas = '".$vartotojo_vardas."' and asmens_id <> ".$_SESSION['id']." LIMIT 1";
			$rows = $database->QueryNumRows($query);
			if ($rows > 0)
			{
				$error .= 'Vartotojas su tokiu vartotojo vardu "'.$vartotojo_vardas.'" jau egzistuoja!<br>';
				$errors['vartotojo_vardas'] = 1;
			}
		}
		if (($slaptazodis == '') or (strlen($slaptazodis) < 4))
		{
			$error .= 'Neįvestas slaptažodis arba slaptažodis per trumpas<br>';
			$errors['slaptazodis'] = 1;
		}
	}

	if (strlen($error) == 0)
	{
		$query = "UPDATE asmenys SET vardas = '".$vardas."', pavarde = '".$pavarde."', pareigos = '".$pareigos."', vartotojo_vardas = '".$vartotojo_vardas."', slaptazodis = '".$slaptazodis."', lygis = '".$lygis."', email = '".$email."' WHERE asmens_id = ".$_SESSION['id'];
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
	$query = "SELECT * FROM asmenys WHERE asmens_id = ".$_SESSION['id'];
	$row = $database->QueryAssoc($query);

	$vardas = $row['vardas'];
	$pavarde = $row['pavarde'];
	$pareigos = $row['pareigos'];
	$vartotojo_vardas = $row['vartotojo_vardas'];
	$slaptazodis = $row['slaptazodis'];
	$lygis = $row['lygis'];
	$email = $row['email'];
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
<form name="vartotojai" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
<input type="hidden" name="submit" value="1">
<tr bgcolor="#DDDDDD">
	<td colspan="2"><b>Vartotojo informacijos keitimas</b></td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right">
		<span <? if ($errors['vardas'] == 1) echo 'style="color: #FF0000"';?>>
			Vardas:
		</span>
	</td>
	<td width="300">
		<input type="text" size="50" maxlength="250" name="vardas" value="<?= $vardas; ?>">
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right">
		<span <? if ($errors['pavarde'] == 1) echo 'style="color: #FF0000"';?>>
			Pavardė:
		</span>
	</td>
	<td>
		<input type="text" size="50" maxlength="250" name="pavarde" value="<?= $pavarde; ?>">
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right">
		<span <? if ($errors['pareigos'] == 1) echo 'style="color: #FF0000"';?>>
			Pareigos:
		</span>
	</td>
	<td>
		<input type="text" size="50" maxlength="250" name="pareigos" value="<?= $pareigos; ?>">
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right">
		<span <? if ($errors['tipas'] == 1) echo 'style="color: #FF0000"';?>>
			Vartotojos tipas:
		</span>
	</td>
	<td>
		<select name="lygis" onchange="showHide();">
			<option <? if ($lygis == 'NULL') echo 'selected'; ?> value="NULL">---</option>
			<option <? if ($lygis == 'admin') echo 'selected'; ?> value="admin"><?= $saugumas['admin']; ?></option>
			<option <? if ($lygis == 'user') echo 'selected'; ?> value="user"><?= $saugumas['user']; ?></option>
			<option <? if ($lygis == 'special') echo 'selected'; ?> value="special"><?= $saugumas['special']; ?></option>
			<option <? if ($lygis == 'guest') echo 'selected'; ?> value="guest"><?= $saugumas['guest']; ?></option>
			<option <? if ($lygis == 'none') echo 'selected'; ?> value="none"><?= $saugumas['none']; ?></option>
		</select>
	</td>
</tr>
<tr bgcolor="#FFFFFF" id="email" style="<? if ($lygis == 'none') echo 'display: none;'; ?>">
	<td align="right">
		<span <? if ($errors['email'] == 1) echo 'style="color: #FF0000"';?>>
			Elektroninio pašto adresas:
		</span>
	</td>
	<td>
		<input type="text" size="50" maxlength="250" name="email" value="<?= $email; ?>">
	</td>
</tr>
<tr bgcolor="#FFFFFF" id="username" style="<? if ($lygis == 'none') echo 'display: none;'; ?>">
	<td align="right">
		<span <? if ($errors['vartotojo_vardas'] == 1) echo 'style="color: #FF0000"';?>>
			Vartotojos vardas:
		</span>
	</td>
	<td>
		<input type="text" size="50" maxlength="250" name="vartotojo_vardas" value="<?= $vartotojo_vardas; ?>">
	</td>
</tr>
<tr bgcolor="#FFFFFF" id="password" style="<? if ($lygis == 'none') echo 'display: none;'; ?>">
	<td align="right">
		<span <? if ($errors['slaptazodis'] == 1) echo 'style="color: #FF0000"';?>>
			Slaptazodis:
		</span>
	</td>
	<td>
		<input type="password" size="50" maxlength="250" name="slaptazodis" value="<?= $slaptazodis; ?>">
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
	document.vartotojai.vardas.value = '';
	document.vartotojai.pavarde.value = '';
	document.vartotojai.pareigos.value = '';
	document.vartotojai.vartotojo_vardas.value = '';
	document.vartotojai.slaptazodis.value = '';
	document.vartotojai.lygis.selectedIndex = 0;
}
function showHide()
{
	if (document.vartotojai.lygis.selectedIndex == 5)
	{
		element = document.getElementById('email');
		element.style.display = 'none';
		element = document.getElementById('username');
		element.style.display = 'none';
		element = document.getElementById('password');
		element.style.display = 'none';
	}
	else
	{
		element = document.getElementById('email');
		element.style.display = 'block';
		element = document.getElementById('username');
		element.style.display = 'block';
		element = document.getElementById('password');
		element.style.display = 'block';
	}
}

document.vartotojai.name.focus();
</script>