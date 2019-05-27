<?

if ($_SESSION['action'] == 'delete')
{
	$query = "SELECT sutarties_id FROM sutartys WHERE parent_id = ".$_SESSION['id'];
	$result = $database->Query($query);
	while ($row = mysqli_fetch_assoc($result))
	{
		$query = "DELETE FROM sutartys WHERE sutarties_id = ".$row['sutarties_id']." LIMIT 1";
		$database->Query($query);
	}

	$query = "DELETE FROM sutartys WHERE sutarties_id = ".$_SESSION['id']." LIMIT 1";
	$database->Query($query);

	unset($_SESSION['action']);
	if (isset($_SESSION['parent_id']))
	{
		$query = "SELECT * FROM sutartys WHERE parent_id = ".$_SESSION['parent_id']." LIMIT 1";
		$num = $database->QueryNumRows($query);
		if ($num > 0)
			$_SESSION['action'] = 'child';
	}

	header('Location: ./index.php');
	ob_clean();
	exit();
}

?>