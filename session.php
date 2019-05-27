<?
session_start();

if (!isset($_SESSION['session']))
{
	if (isset($_SESSION['asmens_id']))
	{
		$_SESSION['session'] = '1';

		header('Location: ./index.php');
		exit();
	}
	else
	{
		header('Location: ./authenticate.php');
		exit();
	}
}
?>