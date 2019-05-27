<?

require_once('./session.php');
require_once('./definitions.php');
require_once('./database.php');
$mysqli = array(
	'hostname' => mysqli_HOSTNAME,
	'database' => mysqli_DATABASE,
	'username' => mysqli_USERNAME,
	'password' => mysqli_PASSWORD
	);
$database = new Database($mysqli, $_SESSION['user']['id']);

require_once 'excelwriter/Excel/Writer.php';

// Create Excel document
$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('sutartys.xls');
//$workbook->setVersion(8);
$worksheet =& $workbook->addWorksheet('Sutartys');
$worksheet->setInputEncoding('ISO-8859-13');
$worksheet->setLandscape();

// Formats
$format_cell =& $workbook->addFormat();
$format_cell->setFontFamily('Tahoma');
$format_cell->setSize(8);
$format_cell->setBorder(1);
$format_cell->setNumFormat('#');
$format_cell->setAlign('left');
$format_middle =& $workbook->addFormat();
$format_middle->setFontFamily('Tahoma');
$format_middle->setSize(8);
$format_middle->setBorder(1);
$format_middle->setNumFormat('#');
$format_middle->setAlign('center');
$format_heading =& $workbook->addFormat();
$format_heading->setBold();
$format_heading->setFontFamily('Tahoma');
$format_heading->setSize(8);
$format_heading->setBorder(2);
$format_heading->setAlign('center');
$format_heading->setFgColor('black');
$format_heading->setPattern(1);
$format_heading->setColor('white');

$worksheet->setColumn(0, 0, 3);
$worksheet->setColumn(1, 1, 10);
$worksheet->setColumn(2, 2, 15);
$worksheet->setColumn(3, 3, 25);
$worksheet->setColumn(4, 4, 30);
$worksheet->setColumn(5, 6, 10);
$worksheet->setColumn(7, 8, 15);
$worksheet->setColumn(9, 10, 25);
$worksheet->setColumn(11, 11, 10);
$worksheet->setColumn(12, 12, 20);

// Heading
$worksheet->write(0, 0, 'Nr.', $format_heading);
$worksheet->write(0, 1, 'Priedas', $format_heading);
$worksheet->write(0, 2, 'Sutarties numeris', $format_heading);
$worksheet->write(0, 3, iconv('UTF-8', 'ISO-8859-13', 'Kita sutarties šalis'), $format_heading);
$worksheet->write(0, 4, 'Objektas', $format_heading);
$worksheet->write(0, 5, 'Data', $format_heading);
$worksheet->write(0, 6, 'Terminas', $format_heading);
$worksheet->write(0, 7, iconv('UTF-8', 'ISO-8859-13', 'Pobūdis'), $format_heading);
$worksheet->write(0, 8, 'Tipas', $format_heading);
$worksheet->write(0, 9, 'Atsakingas asmuo', $format_heading);
$worksheet->write(0, 10, iconv('UTF-8', 'ISO-8859-13', 'Pasirašęs asmuo'), $format_heading);
$worksheet->write(0, 11, 'Galiojimas', $format_heading);
$worksheet->write(0, 12, iconv('UTF-8', 'ISO-8859-13', 'Struktūrinis objektas'), $format_heading);

// Data
$query = $_SESSION['query'];
$result = $database->Query($query);

$row = 1;

while ($data = mysqli_fetch_array($result))
{
	/*
	* Pagrindine sutartis
	*/

	if ($data[4] == '0000-00-00')
		$data[4] = 'Neterminuota';
	if ($data[4] == '1111-11-11')
		$data[4] = 'Iki šalių įsipareigojimų įvykdimo';

	$worksheet->write($row, 0, $row, $format_cell);
	$worksheet->write($row, 1, '', $format_cell);
	for ($i = 0; $i < 11; $i++)
		$worksheet->write($row, $i + 2, iconv('UTF-8', 'ISO-8859-13', $data[$i]), $format_cell);

	$row++;

	/*
	* Priedai
	*/
	if ($_SESSION['excel'] == 'all')
	{
		$query = "SELECT sutartys.numeris, subjektai.pavadinimas AS subjekto_pavadinimas, sutartys.objektas, sutartys.data, sutartys.terminas, sutartys.pobudis, sutartys.tipas, CONCAT(atsakingas.vardas,' ',atsakingas.pavarde) AS atsakingas_darbuotojas, CONCAT(pasirases.vardas,' ',pasirases.pavarde) AS pasirases_darbuotojas, sutartys.galiojimas, objektai.pavadinimas AS objekto_pavadinimas, sutartys.sutarties_id, sutartys.dokumentas FROM sutartys";
		$query .= " LEFT JOIN subjektai ON sutartys.kita_salis = subjektai.subjekto_id";
		$query .= " LEFT JOIN objektai ON sutartys.strukturinis_objektas = objektai.objekto_id";
		$query .= " LEFT JOIN asmenys AS atsakingas ON sutartys.atsakingas_asmuo = atsakingas.asmens_id";
		$query .= " LEFT JOIN asmenys AS pasirases ON sutartys.pasirases_asmuo = pasirases.asmens_id";
		$query .= " WHERE parent_id = ".$data['sutarties_id'];
		$childs = $database->Query($query);

		while ($child = mysqli_fetch_array($childs))
		{
			if ($child[4] == '0000-00-00')
				$child[4] = 'Neterminuota';
			if ($child[4] == '1111-11-11')
				$child[4] = 'Iki šalių įsipareigojimų įvykdimo';

			$worksheet->write($row, 0, $row, $format_cell);
			$worksheet->write($row, 1, 'Taip', $format_middle);
			for ($i = 0; $i < 11; $i++)
				$worksheet->write($row, $i + 2, iconv('UTF-8', 'ISO-8859-13', $child[$i]), $format_cell);

			$row++;
		}
	}
}

$workbook->close();

?>