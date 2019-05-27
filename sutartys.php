<?
define('STR_HIGHLIGHT_SIMPLE', 1);
define('STR_HIGHLIGHT_WHOLEWD', 2);
define('STR_HIGHLIGHT_CASESENS', 4);
define('STR_HIGHLIGHT_STRIPLINKS', 8);

/**
 * Highlight a string in text without corrupting HTML tags
 *
 * @author      Aidan Lister <aidan@php.net>
 * @version     3.1.1
 * @link        http://aidanlister.com/repos/v/function.str_highlight.php
 * @param       string          $text           Haystack - The text to search
 * @param       array|string    $needle         Needle - The string to highlight
 * @param       bool            $options        Bitwise set of options
 * @param       array           $highlight      Replacement string
 * @return      Text with needle highlighted
 */
function str_highlight($text, $needle, $options = null, $highlight = null)
{
    if ($highlight === null)
        $highlight = '<strong>\1</strong>';

    if ($options & STR_HIGHLIGHT_SIMPLE)
	{
        $pattern = '#(%s)#';
        $sl_pattern = '#(%s)#';
    }
	else
	{
        $pattern = '#(?!<.*?)(%s)(?![^<>]*?>)#';
        $sl_pattern = '#<a\s(?:.*?)>(%s)</a>#';
    }

    if (!($options & STR_HIGHLIGHT_CASESENS))
	{
        $pattern .= 'i';
        $sl_pattern .= 'i';
    }

	$needle = (array) $needle;
	foreach ($needle as $needle_s)
	{
        $needle_s = preg_quote($needle_s);

        if ($options & STR_HIGHLIGHT_WHOLEWD)
            $needle_s = '\b' . $needle_s . '\b';

        if ($options & STR_HIGHLIGHT_STRIPLINKS)
		{
            $sl_regex = sprintf($sl_pattern, $needle_s);
            $text = preg_replace($sl_regex, '\1', $text);
        }

        $regex = sprintf($pattern, $needle_s);
		$text = preg_replace($regex, $highlight, $text);
	}

    return $text;
}




if (isset($_SESSION['error']))
{
	?>
	<span style="color: #FF0000; font-weight: bold;"><?= $_SESSION['error']; ?></span>
	<br>
	<?
	unset($_SESSION['error']);
}

$query  = "SELECT sutartys.numeris, subjektai.pavadinimas AS subjekto_pavadinimas, sutartys.objektas, sutartys.data, sutartys.terminas, sutartys.pobudis, sutartys.tipas, CONCAT(atsakingas.vardas,' ',atsakingas.pavarde) AS atsakingas_darbuotojas, CONCAT(pasirases.vardas,' ',pasirases.pavarde) AS pasirases_darbuotojas, sutartys.galiojimas, objektai.pavadinimas AS objekto_pavadinimas, sutartys.sutarties_id, sutartys.dokumentas FROM sutartys";
$query .= " LEFT JOIN subjektai ON sutartys.kita_salis = subjektai.subjekto_id";
$query .= " LEFT JOIN objektai ON sutartys.strukturinis_objektas = objektai.objekto_id";
$query .= " LEFT JOIN asmenys AS atsakingas ON sutartys.atsakingas_asmuo = atsakingas.asmens_id";
$query .= " LEFT JOIN asmenys AS pasirases ON sutartys.pasirases_asmuo = pasirases.asmens_id";
$query .= " WHERE sutartys.parent_id IS NULL";

if ($_SESSION['lygis'] == 'guest')
	$query .= " AND sutartys.atsakingas_asmuo = ".$_SESSION['asmens_id'];

if (isset($_SESSION['filter']))
{
	if ($_SESSION['filter']['numeris'] != '')
		$query .= " AND sutartys.numeris LIKE '%".$_SESSION['filter']['numeris']."%'";
	if ($_SESSION['filter']['kitas_numeris'] != '')
		$query .= " AND sutartys.kitas_numeris LIKE '%".$_SESSION['filter']['kitas_numeris']."%'";
	if ($_SESSION['filter']['kita_salis'] != 'NULL')
		$query .= " AND sutartys.kita_salis = ".$_SESSION['filter']['kita_salis'];
	if ($_SESSION['filter']['data'] != '')
	{
		switch ($_SESSION['filter']['data_kryptis'])
		{
			case 'yra':
				$query .= " AND sutartys.data = '".$_SESSION['filter']['data']."'";
				break;
			case 'pries':
				$query .= " AND sutartys.data < '".$_SESSION['filter']['data']."'";
				break;
			case 'po':
				$query .= " AND sutartys.data > '".$_SESSION['filter']['data']."'";
				break;
		}
	}
	if (isset($_SESSION['filter']['terminas2']))
	{
		if ($_SESSION['filter']['terminas2'] == 'data')
		{
			if ($_SESSION['filter']['terminas1'] != '')
			{
				switch ($_SESSION['filter']['terminas_kryptis'])
				{
					case 'yra':
						$query .= " AND sutartys.terminas = '".$_SESSION['filter']['terminas1']."'";
						break;
					case 'pries':
						$query .= " AND sutartys.terminas < '".$_SESSION['filter']['terminas1']."'";
						break;
					case 'po':
						$query .= " AND sutartys.terminas > '".$_SESSION['filter']['terminas1']."'";
						break;
				}
			}
		}
		else
			$query .= " AND sutartys.terminas = '".$_SESSION['filter']['terminas2']."'";
	}
	if ($_SESSION['filter']['objektas'] != '')
		$query .= " AND sutartys.objektas LIKE '%".$_SESSION['filter']['objektas']."%'";
	if ($_SESSION['filter']['pobudis'] != 'NULL')
		$query .= " AND sutartys.pobudis = '".$_SESSION['filter']['pobudis']."'";
	if ($_SESSION['filter']['tipas'] != 'NULL')
		$query .= " AND sutartys.tipas = '".$_SESSION['filter']['tipas']."'";
	if (($_SESSION['filter']['atsakingas_asmuo'] != 'NULL') and ($_SESSION['lygis'] != 'guest'))
		$query .= " AND sutartys.atsakingas_asmuo = ".$_SESSION['filter']['atsakingas_asmuo'];
	if ($_SESSION['filter']['pasirases_asmuo'] != 'NULL')
		$query .= " AND sutartys.pasirases_asmuo = ".$_SESSION['filter']['pasirases_asmuo'];
	if ($_SESSION['filter']['galiojimas'] != 'NULL')
		$query .= " AND sutartys.galiojimas = '".$_SESSION['filter']['galiojimas']."'";
	if ($_SESSION['filter']['strukturinis_objektas'] != 'NULL')
		$query .= " AND sutartys.strukturinis_objektas = ".$_SESSION['filter']['strukturinis_objektas'];
	if ($_SESSION['filter']['komentaras'] != '')
		$query .= " AND sutartys.komentaras LIKE '%".$_SESSION['filter']['komentaras']."%'";
}
else if (isset($_SESSION['search']))
{
	$search = $_SESSION['search'];
	$query .= " HAVING ((subjekto_pavadinimas LIKE '%".$search."%') OR (sutartys.objektas LIKE '%".$search."%')";
	$query .=   " OR (sutartys.numeris LIKE '%".$search."%')";
	$query .=   " OR (sutartys.data LIKE '%".$search."%') OR (sutartys.terminas LIKE '%".$search."%')";
	$query .=   " OR (sutartys.pobudis LIKE '%".$search."%') OR (sutartys.tipas LIKE '%".$search."%')";
	$query .=   " OR (atsakingas_darbuotojas LIKE '%".$search."%') OR (pasirases_darbuotojas LIKE '%".$search."%')";
	$query .=   " OR (sutartys.galiojimas LIKE '%".$search."%') OR (objekto_pavadinimas LIKE '%".$search."%'))";
}

$query .= " ORDER BY ".$_SESSION['sutartys']['sort'];
$_SESSION['query'] = $query;

$all_rows = $database->QueryNumRows($query);

$pages = floor($all_rows / $_SESSION['eilutes']) - 1;
if ($all_rows % $_SESSION['eilutes'] > 0)
	$pages++;
if ($all_rows <= $_SESSION['eilutes'])
	$pages = 0;

if (isset($_SESSION['go']))
{
	switch ($_SESSION['go'])
	{
		case 'start':
			$_SESSION['puslapis'] = 0;
			break;
		case 'end':
			$_SESSION['puslapis'] = $pages;
			break;
		case 'forward':
			if ($_SESSION['puslapis'] < $pages)
				$_SESSION['puslapis']++;
			break;
		case 'back':
			if ($_SESSION['puslapis'] > 0)
				$_SESSION['puslapis']--;
			break;
	}
	unset($_SESSION['go']);
}

$query .= " LIMIT ".$_SESSION['eilutes']." OFFSET ".$_SESSION['puslapis'] * $_SESSION['eilutes'];

$result = $database->Query($query);
$rows = mysqli_num_rows($result);

if ($rows > 0)
{
	if ($all_rows <= $_SESSION['eilutes'])
	{
		?>
		<table>
		<tr>
			<td>Rodomos visos sutartys</td>
		</tr>
		<tr>
			<td height="3"><img src="style/spacer.gif"></td>
		</tr>
		</table>
		<?
	}
	else
	{
		?>
		<table>
		<form name="pagenr1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
		<tr>
			<td valign="bottom">
			<?
				if ($_SESSION['puslapis'] > 0)
				{
					?>
					<a href="<?= $_SERVER['PHP_SELF']; ?>?go=start"><img src="style/start.gif" border="0"></a>
					<?
				}
				else
				{
					?>
					<img src="style/start_disabled.gif">
					<?
				}
			?>
			</td>
			<td valign="bottom">
			<?
				if ($_SESSION['puslapis'] > 0)
				{
					?>
					<a href="<?= $_SERVER['PHP_SELF']; ?>?go=back"><img src="style/backward.gif" border="0"></a>
					<?
				}
				else
				{
					?>
					<img src="style/backward_disabled.gif">
					<?
				}
			?>
			</td>
			<td>
				&nbsp;Puslapis&nbsp;
					<select name="page_number" onchange="document.pagenr1.submit();">
					<?
					for ($i = 0; $i <= $pages; $i++)
					{
						?>
						<option value="<?= $i; ?>" <? if ($_SESSION['puslapis'] == $i) echo 'selected'; ?>><?= $i + 1; ?></option>
						<?
					}
					?>
					</select>
				&nbsp;iš <b><?= $pages + 1; ?></b>&nbsp;
			</td>
			<td valign="bottom">
			<?
				if ($_SESSION['puslapis'] < $pages)
				{
					?>
					<a href="<?= $_SERVER['PHP_SELF']; ?>?go=forward"><img src="style/forward.gif" border="0"></a>
					<?
				}
				else
				{
					?>
					<img src="style/forward_disabled.gif">
					<?
				}
			?>
			</td>
			<td valign="bottom">
			<?
				if ($_SESSION['puslapis'] < $pages)
				{
					?>
					<a href="<?= $_SERVER['PHP_SELF']; ?>?go=end"><img src="style/end.gif" border="0"></a>
					<?
				}
				else
				{
					?>
					<img src="style/end_disabled.gif">
					<?
				}
			?>
			</td>
		</tr>
		<tr>
			<td height="3"><img src="style/spacer.gif"></td>
		</tr>
		</form>
		</table>
		<?
	}
	?>

	<table width="100%" cellpadding="4" cellspacing="1" bgcolor="#AAAAAA">
	<form name="sutartys" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
	<tr align="center" bgcolor="#DDDDDD">
		<td style="padding-top: 5px; padding-right: 5px;"><img src="style/spacer16.gif"></td>
		<td style="padding-top: 5px; padding-right: 5px;"><img src="style/spacer16.gif"></td>
		<?
		if ($_SESSION['lygis'] == 'admin')
		{
			?>
		<td style="padding-top: 5px; padding-right: 5px;"><img src="style/spacer16.gif"></td>
			<?
		}
		if (($_SESSION['lygis'] == 'admin') or ($_SESSION['lygis'] == 'user'))
		{
			?>
		<td style="padding-top: 5px; padding-right: 5px;"><img src="style/spacer16.gif"></td>
			<?
		}
		?>
		<td style="padding-top: 5px; padding-right: 5px;"><img src="style/spacer16.gif"></td>
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
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=atsakingas_darbuotojas&order=ASC"><img src="style/down<? if (($_SESSION['sutartys']['sort'] == 'atsakingas_darbuotojas ASC')) echo '_selected'; ?>.gif" border="0"></a>
				&nbsp;Atsakingas asmuo
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=atsakingas_darbuotojas&order=DESC"><img src="style/up<? if (($_SESSION['sutartys']['sort'] == 'atsakingas_darbuotojas DESC')) echo '_selected'; ?>.gif" border="0"></a>
		</td>
		<td nowrap>
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pasirases_darbuotojas&order=ASC"><img src="style/down<? if (($_SESSION['sutartys']['sort'] == 'pasirases_darbuotojas ASC')) echo '_selected'; ?>.gif" border="0"></a>
				&nbsp;Pasirašęs asmuo
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pasirases_darbuotojas&order=DESC"><img src="style/up<? if (($_SESSION['sutartys']['sort'] == 'pasirases_darbuotojas DESC')) echo '_selected'; ?>.gif" border="0"></a>
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
		// Sutartis

		$query = "SELECT sutarties_id FROM sutartys WHERE parent_id = '".$row['sutarties_id']."'";
		$child_num = $database->QueryNumRows($query);

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
			if ($child_num > 0)
			{
				?>
				<td style="padding-top: 5px; padding-right: 5px;">
					<a href="javascript: showHide(<?= $row['sutarties_id']; ?>, <?= $child_num; ?>);"><img id="pic<?= $row['sutarties_id']; ?>" src="style/plus.png" alt="Išskleisti priedų sąrašą" border="0"></a>
				</td>
				<td style="padding-top: 5px; padding-right: 5px;">
					<a href="<?= $_SERVER['PHP_SELF']; ?>?action=child&parent_id=<?= $row['sutarties_id']; ?>"><img src="style/expand.gif" alt="Peržiūrėti sutarties priedus" border="0"></a>
				</td>
				<?
			}
			else
			{
				?>
				<td colspan="2"></td>
				<?
			}
			if (($_SESSION['lygis'] == 'admin') or ($_SESSION['lygis'] == 'user'))
			{
				?>
				<td style="padding-right: 5px;"><a href="<?= $_SERVER['PHP_SELF']; ?>?action=edit&id=<?= $row['sutarties_id']; ?>"><img src="style/sutartys_edit.gif" alt="Redaguoti šią sutartį" border="0"></a></td>
				<?
			}
			if ($_SESSION['lygis'] == 'admin')
			{
				?>
				<td style="padding-right: 5px;"><a href="#" onclick="if (confirm('Ar tikrai pašalinti šią sutartį ir visus jos priedus?')) window.location='<?= $_SERVER['PHP_SELF']; ?>?action=delete&id=<?= $row['sutarties_id']; ?>'"><img src="style/sutartys_delete.gif" alt="Pašalinti šią sutartį ir visus jos priedus" border="0"></a></td>
				<?
			}
			?>
			<td style="padding-top: 5px; padding-right: 5px;">
			<?
			if (!is_null($row['dokumentas']))
			{
				?>
				<a href="<?= $row['dokumentas']; ?>" target="_blank"><img src="style/sutartys_document.gif" alt="Peržiūrėti sutarties dokumentą" border="0"></a>
				<?
			}
			?>
			</td>
			<td nowrap><?= str_highlight($row['numeris'], $search); ?></td>
			<td nowrap><?= str_highlight($row['subjekto_pavadinimas'], $search); ?></td>
			<td nowrap><?= str_highlight($row['objektas'], $search); ?></td>
			<td nowrap><?= str_highlight($row['data'], $search); ?></td>
			<td nowrap><?= str_highlight($terminas, $search); ?></td>
			<td nowrap><?= str_highlight($row['pobudis'], $search); ?></td>
			<td nowrap><?= str_highlight($row['tipas'], $search); ?></td>
			<td nowrap><?= str_highlight($row['atsakingas_darbuotojas'], $search); ?></td>
			<td nowrap><?= str_highlight($row['pasirases_darbuotojas'], $search); ?></td>
			<td nowrap><?= str_highlight($row['galiojimas'], $search); ?></td>
			<td nowrap><?= str_highlight($row['objekto_pavadinimas'], $search); ?></td>
		</tr>
		<?


		// Priedai

		$query  = "SELECT sutartys.numeris, subjektai.pavadinimas AS subjekto_pavadinimas, sutartys.objektas, sutartys.data, sutartys.terminas, sutartys.pobudis, sutartys.tipas, CONCAT(atsakingas.vardas,' ',atsakingas.pavarde) AS atsakingas_darbuotojas, CONCAT(pasirases.vardas,' ',pasirases.pavarde) AS pasirases_darbuotojas, sutartys.galiojimas, objektai.pavadinimas AS objekto_pavadinimas, sutartys.sutarties_id, sutartys.dokumentas FROM sutartys";
		$query .= " LEFT JOIN subjektai ON sutartys.kita_salis = subjektai.subjekto_id";
		$query .= " LEFT JOIN objektai ON sutartys.strukturinis_objektas = objektai.objekto_id";
		$query .= " LEFT JOIN asmenys AS atsakingas ON sutartys.atsakingas_asmuo = atsakingas.asmens_id";
		$query .= " LEFT JOIN asmenys AS pasirases ON sutartys.pasirases_asmuo = pasirases.asmens_id";
		$query .= " WHERE parent_id = ".$row['sutarties_id'];
		$query .= " ORDER BY ".$_SESSION['sutartys']['sort'];

		$chresult = $database->Query($query);

		$nr = 0;
		while ($chrow = mysqli_fetch_assoc($chresult))
		{
			$nr++;
			switch ($chrow['terminas'])
			{
				case '0000-00-00':
					$terminas = 'Neterminuota';
					break;
				case '1111-11-11':
					$terminas = 'Iki šalių įsipareigojimų įvykdimo';
					break;
				default:
					$terminas = $chrow['terminas'];
					break;
			}

			$strukturinis_objektas = ((is_null($chrow['objekto_pavadinimas']) == 'NULL') ?  'Nenurodytas' : $chrow['objekto_pavadinimas']);

			?>
			<tr bgcolor="#FFFFFF" id="row<?= $row['sutarties_id'].'_'.$nr; ?>" style="display: none;">
				<td colspan="2" align="left">
				<?
					if ($nr < $child_num)
						$tree = 'thru';
					else
						$tree = 'end';
					?>
					<img src="style/tree_<?= $tree; ?>.gif">
				</td>
				<?
				if (($_SESSION['lygis'] == 'admin') or ($_SESSION['lygis'] == 'user'))
				{
					?>
					<td style="padding-right: 5px;"><a href="<?= $_SERVER['PHP_SELF']; ?>?action=childedit&back=main&child_id=<?= $chrow['sutarties_id']; ?>"><img src="style/sutartys_edit.gif" alt="Redaguoti šį sutarties priedą" border="0"></a></td>
					<?
				}
				if ($_SESSION['lygis'] == 'admin')
				{
					?>
					<td style="padding-right: 5px;"><a href="#" onclick="if (confirm('Ar tikrai pašalinti šį sutarties priedą?')) window.location='<?= $_SERVER['PHP_SELF']; ?>?action=delete&id=<?= $chrow['sutarties_id']; ?>'"><img src="style/sutartys_delete.gif" alt="Pašalinti šį sutarties priedą" border="0"></a></td>
					<?
				}
				?>
				<td style="padding-top: 5px; padding-right: 5px;">
				<?
				if (!is_null($chrow['dokumentas']))
				{
					?>
					<a href="<?= $chrow['dokumentas']; ?>" target="_blank"><img src="style/sutartys_document.gif" alt="Peržiūrėti sutarties priedo dokumentą" border="0"></a>
					<?
				}
				?>
				</td>
				<td nowrap><?= str_highlight($chrow['numeris'], $search); ?></td>
				<td nowrap><?= str_highlight($chrow['subjekto_pavadinimas'], $search); ?></td>
				<td nowrap><?= str_highlight($chrow['objektas'], $search); ?></td>
				<td nowrap><?= str_highlight($chrow['data'], $search); ?></td>
				<td nowrap><?= str_highlight($terminas, $search); ?></td>
				<td nowrap><?= str_highlight($chrow['pobudis'], $search); ?></td>
				<td nowrap><?= str_highlight($chrow['tipas'], $search); ?></td>
				<td nowrap><?= str_highlight($chrow['atsakingas_darbuotojas'], $search); ?></td>
				<td nowrap><?= str_highlight($chrow['pasirases_darbuotojas'], $search); ?></td>
				<td nowrap><?= str_highlight($chrow['galiojimas'], $search); ?></td>
				<td nowrap><?= str_highlight($chrow['objekto_pavadinimas'], $search); ?></td>
			</tr>
			<?
		}
	}
	?>
	</form>
	</table>

	<?
	if ($all_rows >= $_SESSION['eilutes'])
	{
		?>
		<table>
		<form name="pagenr" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
		<tr>
			<td height="3"><img src="style/spacer.gif"></td>
		</tr>
		<tr>
			<td>
			<?
				if ($_SESSION['puslapis'] > 0)
				{
					?>
					<a href="<?= $_SERVER['PHP_SELF']; ?>?go=start"><img src="style/start.gif" border="0"></a>
					<?
				}
				else
				{
					?>
					<img src="style/start_disabled.gif">
					<?
				}
			?>
			</td>
			<td>
			<?
				if ($_SESSION['puslapis'] > 0)
				{
					?>
					<a href="<?= $_SERVER['PHP_SELF']; ?>?go=back"><img src="style/backward.gif" border="0"></a>
					<?
				}
				else
				{
					?>
					<img src="style/backward_disabled.gif">
					<?
				}
			?>
			</td>
			<td>
				&nbsp;Puslapis&nbsp;
					<select name="page_number" onchange="document.pagenr.submit();">
					<?
					for ($i = 0; $i <= $pages; $i++)
					{
						?>
						<option value="<?= $i; ?>" <? if ($_SESSION['puslapis'] == $i) echo 'selected'; ?>><?= $i + 1; ?></option>
						<?
					}
					?>
					</select>
				&nbsp;iš <b><?= $pages + 1; ?></b>&nbsp;
			</td>
			<td>
			<?
				if ($_SESSION['puslapis'] < $pages)
				{
					?>
					<a href="<?= $_SERVER['PHP_SELF']; ?>?go=forward"><img src="style/forward.gif" border="0"></a>
					<?
				}
				else
				{
					?>
					<img src="style/forward_disabled.gif">
					<?
				}
			?>
			</td>
			<td>
			<?
				if ($_SESSION['puslapis'] < $pages)
				{
					?>
					<a href="<?= $_SERVER['PHP_SELF']; ?>?go=end"><img src="style/end.gif" border="0"></a>
					<?
				}
				else
				{
					?>
					<img src="style/end_disabled.gif">
					<?
				}
			?>
			</td>
		</tr>
		</form>
		</table>
		<?
	}
}
else
{
	?>
	&nbsp;&nbsp;Sutarčių registre nėra arba filtravimo parametrus atitinkančių sutarčių nėra
	<?
}
?>

<script>
function showHide(id, nr)
{
	for (i = 1; i <= nr; i++)
	{
		row = document.getElementById('row'+id+'_'+i);
		pic = document.getElementById('pic'+id);
		if (row.style.display == 'none')
		{
			row.style.display = 'block';
			pic.src = 'style/minus.png';
		}
		else
		{
			row.style.display = 'none';
			pic.src = 'style/plus.png';
		}
	}
}
</script>
