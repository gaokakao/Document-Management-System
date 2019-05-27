<?

$numeris = $_SESSION['filter']['numeris'];
$kitas_numeris = $_SESSION['filter']['kitas_numeris'];
$kita_salis = $_SESSION['filter']['kita_salis'];
$data = $_SESSION['filter']['data'];
$data_kryptis = $_SESSION['filter']['data_kryptis'];
$terminas1 = $_SESSION['filter']['terminas1'];
$terminas2 = $_SESSION['filter']['terminas2'];
$terminas_kryptis = $_SESSION['filter']['terminas_kryptis'];
$tipas = $_SESSION['filter']['tipas'];
$pobudis = $_SESSION['filter']['pobudis'];
$objektas = $_SESSION['filter']['objektas'];
$strukturinis_objektas = $_SESSION['filter']['strukturinis_objektas'];
$atsakingas_asmuo = $_SESSION['filter']['atsakingas_asmuo'];
$pasirases_asmuo = $_SESSION['filter']['pasirases_asmuo'];
$dokumentas = $_FILES['dokumentas'];
$galiojimas = $_SESSION['filter']['galiojimas'];
$komentaras = $_SESSION['filter']['komentaras'];

if (isset($_POST['submit']))
{
	$_SESSION['filter'] = $_POST;
	$_SESSION['puslapis'] = 0;
	unset($_SESSION['search']);
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

<table width="600" cellpadding="4" cellspacing="1" bgcolor="#AAAAAA">
<form name="sutartys" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
<input type="hidden" name="submit" value="1">
<tr bgcolor="#DDDDDD">
	<td colspan="4"><b>Filtravimo parametrai</b></td>
</tr>
<tr bgcolor="#FFFFFF">
	<td width="99%" align="right">
		Sutarties numeris (pagal mus):
	</td>
	<td colspan="3">
		<input type="text" size="50" maxlength="250" name="numeris" value="<?= $numeris; ?>">
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right">
		Sutarties numeris (pagal kitą šalį):
	</td>
	<td colspan="3">
		<input type="text" size="50" maxlength="250" name="kitas_numeris" value="<?= $kitas_numeris; ?>">
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right">
		Sutarties kita šalis:
	</td>
	<td colspan="3">
		<select name="kita_salis">
			<option <? if ($kita_salis == 'NULL') echo 'selected' ?> value="NULL">---</option>
			<?
				$query = "SELECT * FROM subjektai ORDER BY pavadinimas";
				$result = $database->Query($query);

				for ($i = 0; $i < mysqli_num_rows($result); $i++)
				{
					$row = mysqli_fetch_assoc($result);
					?>
					<option <? if ($kita_salis == $row['subjekto_id']) echo 'selected' ?> value="<?= $row['subjekto_id']; ?>"><?= $row['pavadinimas']; ?></option>
					<?
				}
			?>
		</select>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		Sutarties sudarymo data:
	</td>
	<td>
		<select name="data_kryptis">
			<option <? if ($data_kryptis == 'pries') echo 'selected';  ?> value="pries">Ankstesnė nei</option>
			<option <? if ($data_kryptis == 'yra') echo 'selected';  ?> value="yra">Yra</option>
			<option <? if ($data_kryptis == 'po') echo 'selected';  ?> value="po">Vėlesnė nei</option>
		</select>
	</td>
	<td width="50">
		<input readonly size="9" maxlength="10" type="text" name="data" value="<?= $data; ?>">
	</td>
	<td width="250">
		<a id="list" href="#" onclick="if(self.gfPop)gfPop.fPopCalendar(document.sutartys.data);return false;"><img src="style/calendar.gif" border="0"></a>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right">
		Sutarties galiojimo terminas:
	</td>
	<td colspan="3">
		<table cellpadding="0" cellspacing="1">
		<tr>
			<td><input <? if ($terminas2 == 'data') echo 'checked'; ?> class="checkbox" type="radio" name="terminas2" value="data" onclick="element = document.getElementById('terminas'); element.style.display = 'block'"></td>
			<td nowrap>Nurodyta data</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td><input <? if ($terminas2 == '0000-00-00') echo 'checked'; ?> class="checkbox" type="radio" name="terminas2" value="0000-00-00" onclick="element = document.getElementById('terminas'); element.style.display = 'none'"></td>
			<td nowrap>Neterminuotai</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td><input <? if ($terminas2 == '1111-11-11') echo 'checked'; ?> class="checkbox" type="radio" name="terminas2" value="1111-11-11" onclick="element = document.getElementById('terminas'); element.style.display = 'none'"></td>
			<td nowrap>Iki šalių įsipareigojimų įvykdimo</td>
			<td>&nbsp;</td>
		</tr>
		</table>
	</td>
</tr>
<tr bgcolor="#FFFFFF" id="terminas">
	<td nowrap align="right">
		Sutarties galiojimo termino data:
	</td>
	<td>
		<select name="terminas_kryptis">
			<option <? if ($terminas_kryptis == 'pries') echo 'selected';  ?> value="pries">Ankstesnė nei</option>
			<option <? if ($terminas_kryptis == 'yra') echo 'selected';  ?> value="yra">Yra</option>
			<option <? if ($terminas_kryptis == 'po') echo 'selected';  ?> value="po">Vėlesnė nei</option>
		</select>
	</td>
	<td>
		<input readonly size="9" maxlength="10" type="text" name="terminas1" value="<?= $terminas1; ?>">
	</td>
	<td>
		<a id="list" href="#" onclick="if(self.gfPop)gfPop.fPopCalendar(document.sutartys.terminas1); document.sutartys.terminas2.selectedIndex = 0; return false;"><img src="style/calendar.gif" border="0"></a>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right">
		Sutarties objektas:
	</td>
	<td colspan="3">
		<textarea rows="3" cols="50" name="objektas" onkeypress="validate_alpha(this);"><?= $objektas; ?></textarea>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right">
		Sutarties pobūdis:
	</td>
	<td colspan="3">
		<select name="pobudis">
			<option <? if ($pobudis == 'NULL') echo 'selected' ?> value="NULL">---</option>
			<option <? if ($pobudis == 'Pirkimas') echo 'selected' ?> value="Pirkimas">Pirkimas</option>
			<option <? if ($pobudis == 'Pardavimas') echo 'selected' ?> value="Pardavimas">Pardavimas</option>
			<option <? if ($pobudis == 'Nuomavimas') echo 'selected' ?> value="Nuomavimas">Nuomavimas</option>
			<option <? if ($pobudis == 'Išsinuomavimas') echo 'selected' ?> value="Išsinuomavimas">Išsinuomavimas</option>
			<option <? if ($pobudis == 'Panaudos suteikimas') echo 'selected' ?> value="Panaudos suteikimas">Panaudos suteikimas</option>
			<option <? if ($pobudis == 'Panaudos gavimas') echo 'selected' ?> value="Panaudos gavimas">Panaudos gavimas</option>
		</select>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right">
		Sutarties tipas:
	</td>
	<td colspan="3">
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

<?
if ($_SESSION['lygis'] != 'guest')
{
	?>
	<tr bgcolor="#FFFFFF">
		<td align="right">
			Atsakingas asmuo:
		</td>
		<td colspan="3">
			<select name="atsakingas_asmuo">
				<option <? if ($atsakingas_asmuo == 'NULL') echo 'selected' ?> value="NULL">---</option>
				<?
					$query = "SELECT * FROM asmenys";
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
	<?
}
?>

<tr bgcolor="#FFFFFF">
	<td align="right">
		Sutartį pasirašęs asmuo:
	</td>
	<td colspan="3">
		<select name="pasirases_asmuo">
			<option <? if ($pasirases_asmuo == 'NULL') echo 'selected' ?> value="NULL">---</option>
			<?
				$query = "SELECT * FROM asmenys";
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
	<td align="right">
		Sutarties galiojimo požymis:
	</td>
	<td colspan="3">
		<select name="galiojimas">
			<option <? if ($galiojimas == 'NULL') echo 'selected' ?> value="NULL">---</option>
			<option <? if ($galiojimas == 'taip') echo 'selected' ?> value="taip">Galiojanti</option>
			<option <? if ($galiojimas == 'ne') echo 'selected' ?> value="ne">Negaliojanti</option>
		</select>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td align="right">
		Struktūrinis objektas:
	</td>
	<td colspan="3">
		<select name="strukturinis_objektas">
			<option <? if ($strukturinis_objektas == 'NULL') echo 'selected' ?> value="NULL">---</option>
			<?
				$query = "SELECT * FROM objektai";
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
	<td align="right">
		Komentaras:
	</td>
	<td colspan="3">
		<textarea rows="3" cols="50" name="komentaras"><?= $komentaras; ?></textarea>
	</td>
</tr>
<tr bgcolor="#DDDDDD">
	<td colspan="4" align="center">
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
	document.sutartys.numeris.value = '';
	document.sutartys.kitas_numeris.value = '';
	document.sutartys.kita_salis.selectedIndex = 0;
	document.sutartys.data.value = '';
	document.sutartys.tipas.selectedIndex = 0;
	document.sutartys.pobudis.selectedIndex = 0;
	document.sutartys.terminas1.value = '';
	document.sutartys.terminas2.selectedIndex = 0;
	document.sutartys.strukturinis_objektas.selectedIndex = 0;
	document.sutartys.atsakingas_asmuo.selectedIndex = 0;
	document.sutartys.pasirases_asmuo.selectedIndex = 0;
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
document.paieska.raktas.focus();
</script>

<iframe width="195" height="209" name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>