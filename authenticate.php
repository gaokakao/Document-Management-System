<?


if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") 

{
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

session_start();

if (isset($_SESSION['asmens_id']))
{


	header('Location: ./index.php');
	exit();
}

require_once('./header.php');
require_once('./definitions.php');

require_once('./database.php');
$mysqli = array(
	'hostname' => mysqli_HOSTNAME,
	'database' => mysqli_DATABASE,
	'username' => mysqli_USERNAME,
	'password' => mysqli_PASSWORD
	);
$database = new Database($mysqli, $language);
if ($database->link == false)
{
	 require_once('./error.php');
	 exit;
}

if (isset($_POST['submit']))
{
	$query = "SELECT * FROM asmenys WHERE vartotojo_vardas = '".$_POST['username']."' AND slaptazodis = '".$_POST['password']."'";
	$result = $database->Query($query);
	$rows = mysqli_num_rows($result);

	if ($rows > 0)
	{
		$row = mysqli_fetch_assoc($result);

		session_start();
		$_SESSION['asmens_id'] = $row['asmens_id'];
		$_SESSION['asmuo'] = $row['vardas'].' '.$row['pavarde'];
		$_SESSION['lygis'] = $row['lygis'];
		$_SESSION['eilutes'] = $row['eilutes'];
		$_SESSION['excel'] = $row['excel'];

		$_SESSION['puslapis'] = 0;

		$_SESSION['mode'] = 'sutartys';
		$_SESSION['sutartys']['sort'] = 'numeris ASC';
		$_SESSION['vartotojai']['sort'] = 'vardas ASC';
		$_SESSION['objektai']['sort'] = 'pavadinimas ASC';
		$_SESSION['subjektai']['sort'] = 'pavadinimas ASC';

		header('Location: ./index.php');
		exit();
	}
	else
		$error = true;
}

?>
<!DOCTYPE html>

<head>
<title><?= PAGE_TITLE ?></title>
<link rel="stylesheet" type="text/css" href="style/other/style.css" />
<meta http-equiv="content-type" content="text/html; charset=<?= PAGE_CHARSET ?>">
</head>

<script>
function validate()
{
	if (document.authenticate.username.value == "")
	{
		alert("Įveskite savo vartotojo vardą!");
		document.authenticate.username.focus();
		return false;
	}
	if (document.authenticate.password.value == "")
	{
		alert("Įveskite savo slaptažodį!");
		document.authenticate.password.focus();
		return false;
	}
	return true;
}

</script>

<body>

<table width="100%" height="100%" cellpadding="0" cellspacing="0">
<tr valign="middle" align="center">
	<td>
		<form name="authenticate" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return validate();">
		<input type="hidden" name="submit" value="1">
		<table width="250" bgcolor="#AAAAAA" cellpadding="4" cellspacing="1">
			<tr bgcolor="#DDDDDD">
				<td colspan="2"><b>Įveskite savo prisijungimo duomenys</b></td>
			</tr>
			<?
			if (isset($error))
			{
				?>
				<tr>
					<td bgcolor="#DDDDDD" colspan="2"><span style="color: red;"><b>Neteisingas vartotojo vardas ar slaptažodis!</b></span></td>
				</tr>
				<?
			}
			?>
			<tr bgcolor="#FFFFFF">
				<td width="150" align="right" nowrap>Vartotojo vardas:</td>
				<td><input autofocus type="text" name="username" size="30" maxlength="30" value="<?= $_POST['username']; ?>"> </td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td align="right" nowrap>Slaptažodis:</td>
				<td><input type="password" name="password" size="30" maxlength="30" value=""> </td>
			</tr>
			<tr bgcolor="#DDDDDD">
				<td align="center" colspan="2"><input type="submit" value="Pirmyn" class="button"></td>
			</tr>
		</table>
		</form>
	</td>
</tr>
</table>

</body>

</html>
