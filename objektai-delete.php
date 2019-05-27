<?

if ($_SESSION['action'] == 'delete')
{
	$query = "SELECT * FROM sutartys WHERE strukturinis_objektas = ".$_SESSION['id'];
	$rows = $database->QueryNumRows($query);

	if ($rows > 0)
	{
		$_SESSION['error'] = 'Negalima pašalinti strukturinio objekto, nes jis nurodytas kaip struktūtinis objektas '.$rows.' sutartyse!';
	}
	else
	{
		$query = "DELETE FROM objektai WHERE objekto_id = ".$_SESSION['id']." LIMIT 1";
		$database->Query($query);
	}

	unset($_SESSION['action']);
	header('Location: ./index.php');
	ob_clean();
	exit();
}

?>