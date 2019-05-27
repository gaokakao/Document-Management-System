<?

if ($_SESSION['action'] == 'delete')
{
	$query = "SELECT * FROM sutartys WHERE kita_salis = ".$_SESSION['id'];
	$rows = $database->QueryNumRows($query);

	if ($rows > 0)
	{
		$_SESSION['error'] = 'Negalima pašalinti šio subjekto, nes jis nurodytas kaip kita sutarties šalis '.$rows.' sutartyse!<br />';
	}
	else
	{
		$query = "DELETE FROM subjektai WHERE subjekto_id = ".$_SESSION['id']." LIMIT 1";
		$database->Query($query);
	}

	unset($_SESSION['action']);
	header('Location: ./index.php');
	ob_clean();
	exit();
}

?>