<?

if (($_SESSION['action'] == 'delete') and ($_SESSION['id'] != $_SESSION['asmens_id']))
{
	$query = "SELECT * FROM sutartys WHERE atsakingas_asmuo = ".$_SESSION['id'];
	$rows = $database->QueryNumRows($query);
	$query = "SELECT * FROM sutartys WHERE pasirases_asmuo = ".$_SESSION['id'];
	$rows += $database->QueryNumRows($query);

	if ($rows > 0)
	{
		$_SESSION['error'] = 'Negalima pašalinti asmens, nes jis nurodytas kaip atsakingas arba pasirašęs asmuo sutartyse!';
	}
	else
	{
		$query = "DELETE FROM asmenys WHERE asmens_id = ".$_SESSION['id']." LIMIT 1";
		$database->Query($query);
	}

	unset($_SESSION['action']);
	header('Location: ./index.php');
	ob_clean();
	exit();
}

?>