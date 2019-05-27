<?

$_SESSION['back'] = 'child';

$query  = "SELECT sutartys.numeris, subjektai.pavadinimas AS subjekto_pavadinimas, sutartys.objektas, sutartys.data, sutartys.terminas, sutartys.pobudis, sutartys.tipas, CONCAT(atsakingas.vardas,' ',atsakingas.pavarde) AS atsakingas_darbuotojas, CONCAT(pasirases.vardas,' ',pasirases.pavarde) AS pasirases_darbuotojas, sutartys.galiojimas, objektai.pavadinimas AS objekto_pavadinimas, sutartys.sutarties_id, sutartys.dokumentas FROM sutartys";
$query .= " LEFT JOIN subjektai ON sutartys.kita_salis = subjektai.subjekto_id";
$query .= " LEFT JOIN objektai ON sutartys.strukturinis_objektas = objektai.objekto_id";
$query .= " LEFT JOIN asmenys AS atsakingas ON sutartys.atsakingas_asmuo = atsakingas.asmens_id";
$query .= " LEFT JOIN asmenys AS pasirases ON sutartys.pasirases_asmuo = pasirases.asmens_id";
$query .= " WHERE sutarties_id = ".$_SESSION['parent_id'];

$row = $database->QueryAssoc($query);
switch ($row['terminas'])
{
	case '0000-00-00':
		$terminas = 'Neterminuota';
		break;
	case '1111-11-11':
		$terminas = 'Iki šalių įsipareigojimų įvykdimo';
		break;
	default:
		$terminas = $row['terminas'];
		break;
}

$strukturinis_objektas = ((is_null($row['objekto_pavadinimas']) == 'NULL') ?  'Nenurodytas' : $row['objekto_pavadinimas']);

?>

Pagrindinė sutartis:
<br><br>

<table width="100%" cellpadding="4" cellspacing="1" bgcolor="#AAAAAA">
	<tr align="center" bgcolor="#DDDDDD">
		<td width="18">&nbsp;</td>
		<td nowrap>Sutarties numeris</td>
		<td nowrap>Kita šalis</td>
		<td nowrap>Objektas</td>
		<td nowrap>Data</td>
		<td nowrap>Terminas</td>
		<td nowrap>Pobūdis</td>
		<td nowrap>Tipas</td>
		<td nowrap>Atsakingas asmuo</td>
		<td nowrap>Pasirašęs asmuo</td>
		<td nowrap>Galiojimas</td>
		<td nowrap>Struktūrinis objektas</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td style="padding-top: 5px; padding-right: 5px;">
		<?
		if (!is_null($row['dokumentas']))
		{
			?>
			<a href="<?= $row['dokumentas']; ?>" target="_blank"><img src="style/sutartys_document.gif" alt="Peržiūrėti dokumentą" border="0"></a>
			<?
		}
		?>
		</td>
		<td nowrap><?= $row['numeris']; ?></td>
		<td nowrap><?= $row['subjekto_pavadinimas']; ?></td>
		<td nowrap><?= $row['objektas']; ?></td>
		<td nowrap><?= $row['data']; ?></td>
		<td nowrap><?= $terminas; ?></td>
		<td nowrap><?= $row['pobudis']; ?></td>
		<td nowrap><?= $row['tipas']; ?></td>
		<td nowrap><?= $row['atsakingas_darbuotojas']; ?></td>
		<td nowrap><?= $row['pasirases_darbuotojas']; ?></td>
		<td nowrap><?= $row['galiojimas']; ?></td>
		<td nowrap><?= $strukturinis_objektas; ?></td>
	</tr>
</table>

<br><br>
Sutarties priedai ir papildymai:
<br><br>

<?

$query  = "SELECT sutartys.numeris, subjektai.pavadinimas AS subjekto_pavadinimas, sutartys.objektas, sutartys.data, sutartys.terminas, sutartys.pobudis, sutartys.tipas, CONCAT(atsakingas.vardas,' ',atsakingas.pavarde) AS atsakingas_darbuotojas, CONCAT(pasirases.vardas,' ',pasirases.pavarde) AS pasirases_darbuotojas, sutartys.galiojimas, objektai.pavadinimas AS objekto_pavadinimas, sutartys.sutarties_id, sutartys.dokumentas FROM sutartys";
$query .= " LEFT JOIN subjektai ON sutartys.kita_salis = subjektai.subjekto_id";
$query .= " LEFT JOIN objektai ON sutartys.strukturinis_objektas = objektai.objekto_id";
$query .= " LEFT JOIN asmenys AS atsakingas ON sutartys.atsakingas_asmuo = atsakingas.asmens_id";
$query .= " LEFT JOIN asmenys AS pasirases ON sutartys.pasirases_asmuo = pasirases.asmens_id";
$query .= " WHERE parent_id = ".$_SESSION['parent_id'];

$query .= " ORDER BY ".$_SESSION['sutartys']['sort'];
$_SESSION['query'] = $query;

//echo $query;

$result = $database->Query($query);
$rows = mysqli_num_rows($result);

?>
<table width="100%" cellpadding="4" cellspacing="1" bgcolor="#AAAAAA">
<form name="sutartys" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
<tr align="center" bgcolor="#DDDDDD">
	<?
	if ($_SESSION['lygis'] == 'admin')
	{
		?>
		<td width="18">&nbsp;</td>
		<?
	}
	if (($_SESSION['lygis'] == 'admin') or ($_SESSION['lygis'] == 'user'))
	{
		?>
		<td width="18">&nbsp;</td>
		<?
	}
	?>
	<td width="18">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=numeris&order=ASC"><img src="style/down<? if (($_SESSION['sutartys']['sort'] == 'numeris ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Sutarties numeris
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=numeris&order=DESC"><img src="style/up<? if (($_SESSION['sutartys']['sort'] == 'numeris DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=subjekto_pavadinimas&order=ASC"><img src="style/down<? if (($_SESSION['sutartys']['sort'] == 'subjekto_pavadinimas ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Kita šalis
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=subjekto_pavadinimas&order=DESC"><img src="style/up<? if (($_SESSION['sutartys']['sort'] == 'subjekto_pavadinimas DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=objektas&order=ASC"><img src="style/down<? if (($_SESSION['sutartys']['sort'] == 'objektas ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Objektas
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=objektas&order=DESC"><img src="style/up<? if (($_SESSION['sutartys']['sort'] == 'objektas DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=data&order=ASC"><img src="style/down<? if (($_SESSION['sutartys']['sort'] == 'data ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Data
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=data&order=DESC"><img src="style/up<? if (($_SESSION['sutartys']['sort'] == 'data DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=terminas&order=ASC"><img src="style/down<? if (($_SESSION['sutartys']['sort'] == 'terminas ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Terminas
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=terminas&order=DESC"><img src="style/up<? if (($_SESSION['sutartys']['sort'] == 'terminas DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pobudis&order=ASC"><img src="style/down<? if (($_SESSION['sutartys']['sort'] == 'pobudis ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Pobūdis
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pobudis&order=DESC"><img src="style/up<? if (($_SESSION['sutartys']['sort'] == 'pobudis DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=tipas&order=ASC"><img src="style/down<? if (($_SESSION['sutartys']['sort'] == 'tipas ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Tipas
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=tipas&order=DESC"><img src="style/up<? if (($_SESSION['sutartys']['sort'] == 'tipas DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=vardas&order=ASC"><img src="style/down<? if (($_SESSION['sutartys']['sort'] == 'vardas ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Atsakingas asmuo
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=vardas&order=DESC"><img src="style/up<? if (($_SESSION['sutartys']['sort'] == 'vardas DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=vardas1&order=ASC"><img src="style/down<? if (($_SESSION['sutartys']['sort'] == 'vardas1 ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Pasirašęs asmuo
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=vardas1&order=DESC"><img src="style/up<? if (($_SESSION['sutartys']['sort'] == 'vardas1 DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=galiojimas&order=ASC"><img src="style/down<? if (($_SESSION['sutartys']['sort'] == 'galiojimas ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Galiojimas
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=galiojimas&order=DESC"><img src="style/up<? if (($_SESSION['sutartys']['sort'] == 'galiojimas DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=objekto_pavadinimas&order=ASC"><img src="style/down<? if (($_SESSION['sutartys']['sort'] == 'objekto_pavadinimas ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Struktūrinis objektas
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=objekto_pavadinimas&order=DESC"><img src="style/up<? if (($_SESSION['sutartys']['sort'] == 'objekto_pavadinimas DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
</tr>

<?

while ($row = mysqli_fetch_assoc($result))
{

	switch ($row['terminas'])
	{
		case '0000-00-00':
			$terminas = 'Neterminuota';
			break;
		case '1111-11-11':
			$terminas = 'Iki šalių įsipareigojimų įvykdimo';
			break;
		default:
			$terminas = $row['terminas'];
			break;
	}

	$strukturinis_objektas = ((is_null($row['objekto_pavadinimas']) == 'NULL') ?  'Nenurodytas' : $row['objekto_pavadinimas']);


	?>
	<tr bgcolor="#FFFFFF">
		<?
		if (($_SESSION['lygis'] == 'admin') or ($_SESSION['lygis'] == 'user'))
		{
			?>
			<td style="padding-right: 5px;"><a href="<?= $_SERVER['PHP_SELF']; ?>?action=childedit&child_id=<?= $row['sutarties_id']; ?>"><img src="style/sutartys_edit.gif" alt="Redaguoti šį įrašą" border="0"></a></td>
			<?
		}
		if ($_SESSION['lygis'] == 'admin')
		{
			?>
			<td style="padding-right: 5px;"><a href="#" onclick="if (confirm('Ar tikrai pašalinti šią sutartį?')) window.location='<?= $_SERVER['PHP_SELF']; ?>?action=delete&id=<?= $row['sutarties_id']; ?>'"><img src="style/sutartys_delete.gif" alt="Pašalinti šį įrašą" border="0"></a></td>
			<?
		}
		?>
		<td style="padding-top: 5px; padding-right: 5px;">
		<?
		if (!is_null($row['dokumentas']))
		{
			?>
			<a href="<?= $row['dokumentas']; ?>" target="_blank"><img src="style/sutartys_document.gif" alt="Peržiūrėti dokumentą" border="0"></a>
			<?
		}
		?>
		</td>
		<td nowrap><?= $row['numeris']; ?></td>
		<td nowrap><?= $row['subjekto_pavadinimas']; ?></td>
		<td nowrap><?= $row['objektas']; ?></td>
		<td nowrap><?= $row['data']; ?></td>
		<td nowrap><?= $terminas; ?></td>
		<td nowrap><?= $row['pobudis']; ?></td>
		<td nowrap><?= $row['tipas']; ?></td>
		<td nowrap><?= $row['atsakingas_darbuotojas']; ?></td>
		<td nowrap><?= $row['pasirases_darbuotojas']; ?></td>
		<td nowrap><?= $row['galiojimas']; ?></td>
		<td nowrap><?= $strukturinis_objektas; ?></td>
	</tr>
	<?
}

?>
</form>
</table>