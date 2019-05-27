<?

$_SESSION['old_action'] = 'child';

$query = "SELECT * FROM sutartys WHERE sutarties_id = ".$_SESSION['parent_id'];
$row = $database->QueryAssoc($query);
$parent_numeris = $row['numeris'];
$kita_salis = $row['kita_salis'];
$terminas2 = 'NULL';

if (isset($_POST['submit']))
{
	$priedas = $_SESSION['parent_id'];
	$numeris = $_POST['numeris'];
	$kitas_numeris = $_POST['kitas_numeris'];
	$query = "SELECT kita_salis FROM sutartys WHERE sutarties_id = ".$_SESSION['parent_id'];
	$row = $database->QueryAssoc($query);
	$data = $_POST['data'];
	$terminas1 = $_POST['terminas1'];
	$terminas2 = $_POST['terminas2'];
	$tipas = $_POST['tipas'];
	$pobudis = $_POST['pobudis'];
	$objektas = $_POST['objektas'];
	$strukturinis_objektas = $_POST['strukturinis_objektas'];
	$atsakingas_asmuo = $_POST['atsakingas_asmuo'];
	$pasirases_asmuo = $_POST['pasirases_asmuo'];
	$dokumentas = $_FILES['dokumentas'];
	$galiojimas = $_POST['galiojimas'];
	$komentaras = $_POST['komentaras'];

	$error = '';
	if ($numeris == '')
	{
		$error .= 'Neįvestas sutarties numeris (pagal mus)<br>';
		$errors['numeris'] = 1;
	}
	else
	{
		$query = "SELECT * FROM sutartys WHERE numeris = '".$numeris."'";
		$rows = $database->QueryNumRows($query);
		if ($rows > 0)
		{
			$error .= 'Toks sutarties numeris "'.$numeris.'" jau egzistuoja<br>';
			$errors['numeris'] = 1;
		}
	}
	if ($data == '')
	{
		$error .= 'Neįvesta sutarties sudarymo data<br>';
		$errors['data'] = 1;
	}
	if (($terminas1 == '') and ($terminas2 == 'NULL'))
	{
		$error .= 'Nenurodytas sutarties terminas<br>';
		$errors['terminas'] = 1;
	}
	if ($pobudis == 'NULL')
	{
		$error .= 'Neįvestas sutarties pobudis<br>';
		$errors['pobudis'] = 1;
	}
	if ($tipas == 'NULL')
	{
		$error .= 'Neįvestas sutarties tipas<br>';
		$errors['tipas'] = 1;
	}
	if ($atsakingas_asmuo == 'NULL')
	{
		$error .= 'Nepasirinktas atsakingas asmuo<br>';
		$errors['atsakingas_asmuo'] = 1;
	}
	if ($pasirases_asmuo == 'NULL')
	{
		$error .= 'Nepasirinktas pasirases asmuo<br>';
		$errors['pasirases_asmuo'] = 1;
	}
	if ($galiojimas == 'NULL')
	{
		$error .= 'Nepasirinktas sutarties galiojimas<br>';
		$errors['galiojimas'] = 1;
	}
	if (($dokumentas['size'] == 0) and ($komentaras == ''))
	{
		$error .= 'Neįvestas sutarties komentaras ar sutarties dokumentas<br>';
		$errors['dokumentas'] = 1;
	}

	if (strlen($error) == 0)
	{
		$terminas = (($terminas2 == 'NULL') ? $terminas1 : $terminas2);

		$query = "INSERT INTO sutartys (parent_id, numeris, kitas_numeris, kita_salis, data, terminas, objektas, tipas, pobudis, strukturinis_objektas, atsakingas_asmuo, pasirases_asmuo, dokumentas, galiojimas, komentaras) VALUES (".$priedas.", '".$numeris."', '".$kitas_numeris."', ".$kita_salis.", '".$data."', '".$terminas."', '".$objektas."', '".$tipas."', '".$pobudis."', ".$strukturinis_objektas.", ".$atsakingas_asmuo.", ".$pasirases_asmuo.", '', '".$galiojimas."', '".$komentaras."')";
		$database->Query($query);
		$_SESSION['new_id'] = mysqli_insert_id();
		unset($_SESSION['action']);

		$new_id = mysqli_insert_id();

		if ($dokumentas['size'] > 0)
		{
			$uploadfile = 'documents/'.$new_id.'.'.substr($dokumentas['name'], strlen($dokumentas['name']) - 3, 3);
			move_uploaded_file($dokumentas['tmp_name'], $uploadfile);
		}
		else
		{
			$uploadfile = NULL;
		}

		if (is_null($uploadfile))
			$query = "UPDATE sutartys SET dokumentas = NULL WHERE sutarties_id = ".$new_id;
		else
			$query = "UPDATE sutartys SET dokumentas = '".$uploadfile."' WHERE sutarties_id = ".$new_id;
		$database->Query($query);

		require_once('mail-new.php');

		if ($_SESSION['back'] == 'child')
		{
			$_SESSION['action'] = 'child';
			unset($_SESSION['back']);
			unset($_SESSION['child_id']);
		}
		else
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


<table width="600" cellpadding="4" cellspacing="1" bgcolor="#AAAAAA">
<form name="sutartys" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" onSubmit="return disableButtons();">
<input type="hidden" name="submit" value="1">
<input type="hidden" name="MAX_FILE_SIZE" value="10240000">
<input type="hidden" name="filename" value="0">
<tr bgcolor="#DDDDDD">
	<td colspan="4"><b>Naujas sutarties Nr. <?= $parent_numeris; ?> priedas</b></td>
</tr>
<tr bgcolor="#FFFFFF">
	<td  align="right">
		<span <? if ($errors['numeris'] == 1) echo 'style="color: #FF0000"';?>>
			Sutarties numeris (pagal mus):
		</span>
	</td>
	<td colspan="2">
		<input type="text" size="50" maxlength="250" name="numeris" value="<?= $numeris; ?>">
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right">
		Sutarties kita šalis:
	</td>
	<td colspan="2">
		<?
			$query = "SELECT pavadinimas FROM subjektai WHERE subjekto_id = ".$kita_salis;
			$row = $database->QueryAssoc($query);
			echo $row['pavadinimas'];
		?>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		Sutarties numeris (pagal kitą šalį):
	</td>
	<td colspan="2">
		<input type="text" size="50" maxlength="250" name="kitas_numeris" value="<?= $kitas_numeris; ?>">
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		<span <? if ($errors['data'] == 1) echo 'style="color: #FF0000"';?>>
			Sutarties sudarymo data:
		</span>
	</td>
	<td width="1%">
		<input readonly size="9" maxlength="10" type="text" name="data" value="<?= $data; ?>">
	</td>
	<td>
		<a id="list" href="#" onclick="if(self.gfPop)gfPop.fPopCalendar(document.sutartys.data);return false;"><img src="style/calendar.gif" border="0"></a>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right">
		<span <? if ($errors['terminas'] == 1) echo 'style="color: #FF0000"';?>>
			Sutarties galiojimo terminas:
		</span>
	</td>
	<td colspan="2">
		<table cellpadding="0" cellspacing="1">
		<tr>
			<td><input <? if ($terminas2 == 'NULL') echo 'checked'; ?> class="checkbox" type="radio" name="terminas2" value="NULL" onclick="element = document.getElementById('terminas'); element.style.display = 'block'"></td>
			<td>Nurodyta data</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td><input <? if ($terminas2 == '0000-00-00') echo 'checked'; ?> class="checkbox" type="radio" name="terminas2" value="0000-00-00" onclick="element = document.getElementById('terminas'); element.style.display = 'none'"></td>
			<td>Neterminuotai</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td><input <? if ($terminas2 == '1111-11-11') echo 'checked'; ?> class="checkbox" type="radio" name="terminas2" value="1111-11-11" onclick="element = document.getElementById('terminas'); element.style.display = 'none'"></td>
			<td>Iki šalių įsipareigojimų įvykdimo</td>
			<td>&nbsp;</td>
		</tr>
		</table>
	</td>
</tr>
<tr bgcolor="#FFFFFF" id="terminas" style="<? if (($terminas2 == '0000-00-00') or ($terminas2 == '1111-11-11')) echo 'display: none;'; ?>">
	<td align="right">
		<span <? if ($errors['terminas'] == 1) echo 'style="color: #FF0000"';?>>
			Sutartis galioja iki:
		</span>
	</td>
	<td>
		<input readonly size="9" maxlength="10" type="text" name="terminas1" value="<?= $terminas1; ?>">
	</td>
	<td>
		<a id="list" href="#" onclick="if(self.gfPop)gfPop.fPopCalendar(document.sutartys.terminas1); document.sutartys.terminas2.selectedIndex = 0; return false;"><img src="style/calendar.gif" border="0"></a>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		Sutarties objektas:
	</td>
	<td colspan="2">
		<textarea rows="3" cols="50" name="objektas"><?= $objektas; ?></textarea>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		<span <? if ($errors['pobudis'] == 1) echo 'style="color: #FF0000"';?>>
			Sutarties pobūdis:
		</span>
	</td>
	<td colspan="2">
		<select name="pobudis">
			<option <? if ($pobudis == 'NULL') echo 'selected' ?> value="NULL">---</option>
			<option <? if ($pobudis == 'Pirkimas') echo 'selected' ?> value="Pirkimas">Pirkimas</option>
			<option <? if ($pobudis == 'Pardavimas') echo 'selected' ?> value="Pardavimas">Pardavimas</option>
			<option <? if ($pobudis == 'Nuomavimas') echo 'selected' ?> value="Nuomavimas">Nuomavimas</option>
			<option <? if ($pobudis == 'Išsinuomavimas') echo 'selected' ?> value="Išsinuomavimas">Išsinuomavimas</option>
			<option <? if ($pobudis == 'Panaudos suteikimas') echo 'selected' ?> value="Panaudos suteikimas">Panaudos suteikimas</option>
			<option <? if ($pobudis == 'Panaudos gavimas') echo 'selected' ?> value="Panaudos gavimas">Panaudos gavimas</option>
			<option <? if ($pobudis == 'Kito pobūdžio') echo 'selected' ?> value="Kito pobūdžio">Kito pobūdžio</option>
		</select>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		<span <? if ($errors['tipas'] == 1) echo 'style="color: #FF0000"';?>>
			Sutarties tipas:
		</span>
	</td>
	<td colspan="2">
		<select name="tipas">
			<option <? if ($tipas == 'NULL') echo 'selected' ?> value="NULL">---</option>
			<option <? if ($tipas == 'Naftos produktai') echo 'selected' ?> value="Naftos produktai">Naftos produktai</option>
			<option <? if ($tipas == 'Žemė') echo 'selected' ?> value="Žemė">Žemė</option>
			<option <? if ($tipas == 'Nekilnojamas turtas') echo 'selected' ?> value="Nekilnojamas turtas">Nekilnojamas turtas</option>
			<option <? if ($tipas == 'Paslaugos') echo 'selected' ?> value="Paslaugos">Paslaugos</option>
			<option <? if ($tipas == 'Prekės') echo 'selected' ?> value="Prekės">Prekės</option>
			<option <? if ($tipas == 'Finansinės paslaugos') echo 'selected' ?> value="Finansinės paslaugos">Finansinės paslaugos</option>
			<option <? if ($tipas == 'Ranga') echo 'selected' ?> value="Ranga">Ranga</option>
			<option <? if ($tipas == 'Kita') echo 'selected' ?> value="Kita">Kita</option>
		</select>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		<span <? if ($errors['atsakingas_asmuo'] == 1) echo 'style="color: #FF0000"';?>>
			Atsakingas asmuo:
		</span>
	</td>
	<td colspan="2">
		<select name="atsakingas_asmuo">
			<option <? if ($atsakingas_asmuo == 'NULL') echo 'selected' ?> value="NULL">---</option>
			<?
				$query = "SELECT * FROM asmenys ORDER BY vardas, pavarde ASC";
				$result = $database->Query($query);

				for ($i = 0; $i < mysqli_num_rows($result); $i++)
				{
					$row = mysqli_fetch_assoc($result);
					?>
					<option <? if ($atsakingas_asmuo == $row['asmens_id']) echo 'selected' ?> value="<?= $row['asmens_id']; ?>"><?= $row['vardas']; ?> <?= $row['pavarde']; ?></option>
					<?
				}
			?>
		</select>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		<span <? if ($errors['pasirases_asmuo'] == 1) echo 'style="color: #FF0000"';?>>
			Sutartį pasirašęs asmuo:
		</span>
	</td>
	<td colspan="2">
		<select name="pasirases_asmuo">
			<option <? if ($pasirases_asmuo == 'NULL') echo 'selected' ?> value="NULL">---</option>
			<?
				$query = "SELECT * FROM asmenys ORDER BY vardas, pavarde ASC";
				$result = $database->Query($query);

				for ($i = 0; $i < mysqli_num_rows($result); $i++)
				{
					$row = mysqli_fetch_assoc($result);
					?>
					<option <? if ($pasirases_asmuo == $row['asmens_id']) echo 'selected' ?> value="<?= $row['asmens_id']; ?>"><?= $row['vardas']; ?> <?= $row['pavarde']; ?></option>
					<?
				}
			?>
		</select>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		<span <? if ($errors['galiojimas'] == 1) echo 'style="color: #FF0000"';?>>
			Sutarties galiojimo požymis:
		</span>
	</td>
	<td colspan="2">
		<select name="galiojimas">
			<option <? if ($galiojimas == 'NULL') echo 'selected' ?> value="NULL">---</option>
			<option <? if ($galiojimas == 'taip') echo 'selected' ?> value="taip">Galiojanti</option>
			<option <? if ($galiojimas == 'ne') echo 'selected' ?> value="ne">Negaliojanti</option>
		</select>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		Struktūrinis objektas:
	</td>
	<td colspan="2">
		<select name="strukturinis_objektas">
			<option <? if ($strukturinis_objektas == 'NULL') echo 'selected' ?> value="NULL">---</option>
			<?
				$query = "SELECT * FROM objektai ORDER BY pavadinimas ASC";
				$result = $database->Query($query);

				for ($i = 0; $i < mysqli_num_rows($result); $i++)
				{
					$row = mysqli_fetch_assoc($result);
					?>
					<option <? if ($strukturinis_objektas == $row['objekto_id']) echo 'selected' ?> value="<?= $row['objekto_id']; ?>"><?= $row['pavadinimas']; ?></option>
					<?
				}
			?>
		</select>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		<span <? if ($errors['dokumentas'] == 1) echo 'style="color: #FF0000"';?>>
			Komentaras:
		</span>
	</td>
	<td colspan="2">
		<textarea rows="3" cols="50" name="komentaras"><?= $komentaras; ?></textarea>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		<span <? if ($errors['dokumentas'] == 1) echo 'style="color: #FF0000"';?>>
			Sutarties dokumentas:
		</span>
	</td>
	<td colspan="2">
		<input type="file" size="50" maxlength="250" name="dokumentas">
	</td>
</tr>
<tr bgcolor="#DDDDDD">
	<td colspan="3" align="center">
		<input type="button" name="clear" class="button" value="Išvalyti" onclick="resetForm();">
		&nbsp;&nbsp;
		<input type="submit" name="enter" class="button" value="Įvesti">
	</td>
</tr>
</form>
</table>

<script>
function resetForm()
{
	document.sutartys.numeris.value = '';
	document.sutartys.kitas_numeris.value = '';
	document.sutartys.objektas.value = '';
	document.sutartys.data.value = '';
	document.sutartys.tipas.selectedIndex = 0;
	document.sutartys.pobudis.selectedIndex = 0;
	document.sutartys.terminas1.value = '';
	document.sutartys.strukturinis_objektas.selectedIndex = 0;
	document.sutartys.atsakingas_asmuo.selectedIndex = 0;
	document.sutartys.pasirases_asmuo.selectedIndex = 0;
	document.sutartys.dokumentas.value = '';
	document.sutartys.galiojimas.selectedIndex = 0;
	document.sutartys.komentaras.value = '';
}
function showHide(ID)
{
  	var element = document.getElementById(ID);
  	if (document.sutartys.sutartis.selectedIndex == 1)
  	{
  		element.style.display = "block";
  	}
  	else
  	{
  		element.style.display = "none";
  	}
}
function disableButtons()
{
	document.sutartys.clear.disabled = true;
	document.sutartys.enter.disabled = true;
}

document.sutartys.numeris.focus();
</script>

<iframe width="195" height="209" name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>