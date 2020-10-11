<?




// Sesija, nustatymai
require_once('./session.php');
require_once('./definitions.php');

// Duomenu bazes pajungimas
require_once('./database.php');
$mysqli = array(
	'hostname' => mysqli_HOSTNAME,
	'database' => mysqli_DATABASE,
	'username' => mysqli_USERNAME,
	'password' => mysqli_PASSWORD
	);
$database = new Database($mysqli, $_SESSION['user']['id']);
if ($database->link == false)
{
	 require_once('./error.php');
	 exit;
}

// HTML header'is
require_once('./header.php');

$saugumas = array(
	'admin' => 'Administartorius',
	'user' => 'Registratorius',
	'special' => 'VIP',
	'guest' => 'Paprastas',
	'none' => 'Be prisijungimo teisės'
	);

$days = array(
	'sekmadienis',
	'pirmadienis',
	'antradienis',
	'trečiadienis',
	'ketvirtadienis',
	'penktadienis',
	'šeštadienis'
	);

ob_start();
?>

<!DOCTYPE html>

<head>
<title><?= PAGE_TITLE ?></title>
<link rel="stylesheet" type="text/css" href="style/other/style.css" />
<meta http-equiv="content-type" content="text/html; charset=<?= PAGE_CHARSET ?>">
<script src="style/other/functions.js" language="Javascript" type="text/javascript"></script>
</head>

<body>
<table width="100%" height="90%" cellpadding="0" cellspacing="0">
<tr > 
	<td height="35" valign="middle">

		<table width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
			<?

			switch ($_SESSION['lygis'])
			{
				case 'admin':
				case 'user':
					$menu = array (
						'sutartys',
						'subjektai',
						'objektai',
						'vartotojai',
						'nustatymai'
						);
					break;
				case 'special':
				case 'guest':
					$menu = array (
						'sutartys',
						'nustatymai'
						);
					break;
				default:
					$menu = array (
						'sutartys',
						'nustatymai'
						);
					break;
			}
			if (!in_array($_SESSION['mode'], $menu))
			{
				$_SESSION['mode'] = 'sutartys';
			}


			foreach ($menu as $item)
			{

				?>
				<td onclick="window.location='<?= $_SERVER['PHP_SELF']; ?>?mode=<?= $item; ?>'" onmouseover="bgColor='#BDE09B'" onmouseout="bgColor='<? if ($_SESSION['mode'] == $item) echo '#BDE09B'; else echo '#FFFFFF'; ?>'" bgcolor="<? if ($_SESSION['mode'] == $item) echo '#BDE09B'; else echo '#FFFFFF'; ?>" style="cursor:pointer">
					<table cellpadding="3" cellspacing="1">
					<tr>
						<td><img src="style/<?= $item; ?>.gif"></td>
						<td nowrap><b>
						<?
							$item = (($item == 'objektai') ? 'objektai' : $item);
							echo ucfirst($item);
						?>
						</b></td>
					</tr>
					</table>
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<?
			}
			?>
			<td onclick="javascript: if (confirm('Ar tikrai baigti darbą?')) window.location='end.php';" onmouseover="bgColor='#BDE09B'" onmouseout="bgColor='#FFFFFF'" bgcolor="#FFFFFF" style="cursor:pointer">
				<table cellpadding="3" cellspacing="1">
				<tr>
					<td><img src="style/pabaiga.gif"></td>
					<td nowrap><b>Bagti darbą</b></td>
				</tr>
				</table>
			</td>
			<td width="99%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
		</table>

	</td>
</tr>

<tr> <td width="99%" >&nbsp;&nbsp;&nbsp;&nbsp;</td> </tr>
<tr><td height="1" bgcolor="#999999"><img src="style/spacer.gif"></td></tr>
<tr>
	<td height="25">
		<table width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td bgcolor="#F0F0F0"></td>
			<?


			if ($_SESSION['mode'] == 'sutartys')
			{
				if (!isset($_SESSION['action']))
				{
					if (($_SESSION['lygis'] == 'admin') or ($_SESSION['lygis'] == 'user'))
					{
						?>
						<td onclick="window.location='<?= $_SERVER['PHP_SELF']; ?>?action=new'" onmouseover="bgColor='#9BBDE1'" onmouseout="bgColor='#F0F0F0'" bgcolor="#F0F0F0" style="cursor:pointer">
							<table cellpadding="3" cellspacing="1">
							<tr>
								<td><img src="style/sutartys_add.gif"></td>
								<td nowrap><b>Nauja sutartis</b></td>
							</tr>
							</table>
						</td>
						<td bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<?
					}
					?>
					<td onclick="window.location='<?= $_SERVER['PHP_SELF']; ?>?action=search'" onmouseover="bgColor='#9BBDE1'" onmouseout="bgColor='#F0F0F0'" bgcolor="#F0F0F0" style="cursor:pointer">
						<table cellpadding="3" cellspacing="1">
						<tr>
							<td><img src="style/sutartys_search.gif"></td>
							<td nowrap><b>Greita paieška</b></td>
						</tr>
						</table>
					</td>
					<td bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td onclick="window.location='<?= $_SERVER['PHP_SELF']; ?>?action=filter'" onmouseover="bgColor='#9BBDE1'" onmouseout="bgColor='#F0F0F0'" bgcolor="#F0F0F0" style="cursor:pointer">
						<table cellpadding="3" cellspacing="1">
						<tr>
							<td><img src="style/sutartys_filter.gif"></td>
							<td nowrap><b>Filtruoti sąrašą</b></td>
						</tr>
						</table>
					</td>
					<td bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<?
					if ((isset($_SESSION['filter'])) or (isset($_SESSION['search'])))
					{
						?>
						<td onclick="window.location='<?= $_SERVER['PHP_SELF']; ?>?action=unfilter'" onmouseover="bgColor='#9BBDE1'" onmouseout="bgColor='#F0F0F0'" bgcolor="#F0F0F0" style="cursor:pointer">
							<table cellpadding="3" cellspacing="1">
							<tr>
								<td><img src="style/sutartys_unfilter.gif"></td>
								<td nowrap><b>Pašalinti filtravimą/paiešką</b></td>
							</tr>
							</table>
						</td>
						<td bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<?
					}
					?>
					<td onclick="window.open('sutartys-excel.php')" onmouseover="bgColor='#9BBDE1'" onmouseout="bgColor='#F0F0F0'" bgcolor="#F0F0F0" style="cursor:pointer">
						<table cellpadding="3" cellspacing="1">
						<tr>
							<td><img src="style/sutartys_excel.gif"></td>
							<td nowrap><b>Perkelti į Excel</b></td>
						</tr>
						</table>
					</td>
					<?
				}
				else
				{
					if (($_SESSION['back'] == 'child') and ($_SESSION['action'] != 'child'))
						$reset = 'child';
					else
						$reset = 'reset';
					?>
					<td onclick="window.location='<?= $_SERVER['PHP_SELF']; ?>?action=<?= $reset; ?>'" onmouseover="bgColor='#9BBDE1'" onmouseout="bgColor='#F0F0F0'" bgcolor="#F0F0F0" style="cursor:pointer">
						<table cellpadding="3" cellspacing="1">
						<tr>
							<td><img src="style/back.gif"></td>
							<td nowrap><b>Grižti</b></td>
						</tr>
						</table>
					</td>
					<td bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<?
					if ($_SESSION['action'] == 'child')
					{
						?>
						<td bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td onclick="window.location='<?= $_SERVER['PHP_SELF']; ?>?action=childnew'" onmouseover="bgColor='#9BBDE1'" onmouseout="bgColor='#F0F0F0'" bgcolor="#F0F0F0" style="cursor:pointer">
							<table cellpadding="3" cellspacing="1">
							<tr>
								<td><img src="style/sutartys_add.gif"></td>
								<td nowrap><b>Įvesti naują priedą</b></td>
							</tr>
							</table>
						</td>
						<?
					}
				}
			}
			else if ($_SESSION['mode'] == 'nustatymai')
			{
				?>
				<td bgcolor="#F0F0F0">&nbsp;</td>
				<?
			}
			else
			{
				switch ($_SESSION['mode'])
				{
					case 'subjektai':
						$text = 'subjektas';
						break;
					case 'objektai':
						$text = 'struktūrinis objektas';
						break;
					case 'vartotojai':
						$text = 'vartotojas';
						break;
				}

				if (!isset($_SESSION['action']))
				{
					?>
					<td onclick="window.location='<?= $_SERVER['PHP_SELF']; ?>?action=new'" onmouseover="bgColor='#9BBDE1'" onmouseout="bgColor='#F0F0F0'" bgcolor="#F0F0F0" style="cursor:pointer">
						<table cellpadding="3" cellspacing="1">
						<tr>
							<td><img src="style/<?= $_SESSION['mode']; ?>_add.gif"></td>
							<td nowrap><b>Naujas <?= $text; ?></b></td>
						</tr>
						</table>
					</td>
					<td bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<?
				}
				else
				{
					?>
					<td onclick="window.location='<?= $_SERVER['PHP_SELF']; ?>?action=reset'" onmouseover="bgColor='#9BBDE1'" onmouseout="bgColor='#F0F0F0'" bgcolor="#F0F0F0" style="cursor:pointer">
						<table cellpadding="3" cellspacing="1">
						<tr>
							<td><img src="style/back.gif"></td>
							<td nowrap><b>Grižti</b></td>
						</tr>
						</table>
					</td>
					<td bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<?
				}
			}



			?>
			<td width="99%" bgcolor="#F0F0F0">&nbsp;</td>
			<td bgcolor="#F0F0F0" nowrap>Prisjungęs vartotojas: <b><?= $_SESSION['asmuo']; ?></b>. Dabar yra <b><?= date('H:i'); ?></b> val., <b><?= $days[date('w')]; ?></b>, <b><?= date('Y.m.d'); ?></b>&nbsp;</b></td>
		</tr>
		
		
		</table>
	</td>
	
	
</tr>
<tr> <td width="99%" >&nbsp;&nbsp;&nbsp;&nbsp;</td> </tr>

<tr> <td width="99%" >&nbsp;&nbsp;&nbsp;&nbsp;</td> </tr>
<tr height="99%">
	<td valign="top">

	<table cellpadding="4" cellspacing="0" >
	<tr><td>
	<?
		/**
		* Modulio pasirinkimas
		*/
		if (isset($_GET['mode']))
		{
			$_SESSION['mode'] = $_GET['mode'];
			unset($_SESSION['back']);
			unset($_SESSION['action']);
			unset($_SESSION['id']);
			unset($_SESSION['child_id']);
			unset($_SESSION['parent_id']);
		}

		/**
		* Rezimo pasirinkimas
		*/
		if (isset($_GET['action']))
			$_SESSION['action'] = $_GET['action'];
		if ($_SESSION['action'] == 'reset')
		{
			unset($_SESSION['back']);
			unset($_SESSION['action']);
			unset($_SESSION['id']);
			unset($_SESSION['child_id']);
			unset($_SESSION['parent_id']);
		}

		if (isset($_GET['id']))
			$_SESSION['id'] = $_GET['id'];
		if (isset($_GET['child_id']))
			$_SESSION['child_id'] = $_GET['child_id'];
		if (isset($_GET['parent_id']))
			$_SESSION['parent_id'] = $_GET['parent_id'];

		/**
		* Rusiavimo pasirinkimas
		*/
		if (isset($_GET['sort']))
			$_SESSION[$_SESSION['mode']]['sort'] = $_GET['sort'].' '.$_GET['order'];

		/**
		* Puslapiavimas
		*/
		if (isset($_GET['go']))
			$_SESSION['go'] = $_GET['go'];
		if (isset($_POST['page_number']))
			$_SESSION['puslapis'] = $_POST['page_number'];

		/**
		* Filtravimo pasirinkimas
		*/
		if (isset($_GET['unfilter']))
			unset($_SESSION['filter']);

		if (sizeof($_GET) > 0)
		{
			header('Location: ./index.php');
			ob_clean();
			exit();
		}

		$module = $_SESSION['mode'];
		$module .= ((isset($_SESSION['action'])) ? '-'.$_SESSION['action'] : '' );
		$module .= '.php';

		require_once($module);

	?>
	</td></tr>
	
	</table>

	</td>
</tr>
</table>

</body>

</html>

<?
ob_flush();

$database->Disconnect();

?>