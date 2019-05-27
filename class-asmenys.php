<?

if (!isset($_SESSION['asmenys']['sort']))
{
	$_SESSION['asmenys']['sort'] = 'vardas';
	$_SESSION['asmenys']['order'] = 'ASC';
}
if (isset($_GET['sort']))
{
	$_SESSION['asmenys']['sort'] = $_GET['sort'];
	$_SESSION['asmenys']['order'] = $_GET['order'];
	header('Location: ./index.php');
	ob_clean();
	exit();	
}

if (isset($_GET['do']))
{
	?>
	<?
}
else 
{

?>
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td nowrap><a href="<?= $_SRVER['PHP_SELF']; ?>?do=new">Naujas</a>&nbsp;&nbsp;&nbsp;</td>
		<td nowrap><a href="#" onclick="if (confirm('Ar tikrai šalinti pažymėtus asmenys?')) document.asmenys.submit();">Šalinti</a>&nbsp;&nbsp;&nbsp;</td>
		<td width="99%">&nbsp;</td>
	</tr>
	</table>
	<hr>
	
	<table width="100%" cellpadding="4" cellspacing="1" class="list" class="list">
	<tr align="center" class="list-heading">
		<td width="1%">&nbsp;</td>
		<td nowrap>
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=vardas&order=ASC"><img src="style/down<? if (($_SESSION['asmenys']['sort'] == 'vardas') and ($_SESSION['asmenys']['order'] == 'ASC')) echo '_selected'; ?>.gif" border="0"></a>
				&nbsp;Vardas
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=vardas&order=DESC"><img src="style/up<? if (($_SESSION['asmenys']['sort'] == 'vardas') and ($_SESSION['asmenys']['order'] == 'DESC')) echo '_selected'; ?>.gif" border="0"></a>
		</td>
		<td nowrap>
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pavarde&order=ASC"><img src="style/down<? if (($_SESSION['asmenys']['sort'] == 'pavarde') and ($_SESSION['asmenys']['order'] == 'ASC')) echo '_selected'; ?>.gif" border="0"></a>
				&nbsp;Pavardė
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pavarde&order=DESC"><img src="style/up<? if (($_SESSION['asmenys']['sort'] == 'pavarde') and ($_SESSION['asmenys']['order'] == 'DESC')) echo '_selected'; ?>.gif" border="0"></a>
		</td>
		<td nowrap>
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pareigos&order=ASC"><img src="style/down<? if (($_SESSION['asmenys']['sort'] == 'pareigos') and ($_SESSION['asmenys']['order'] == 'ASC')) echo '_selected'; ?>.gif" border="0"></a>
				&nbsp;Pareigos
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pareigos&order=DESC"><img src="style/up<? if (($_SESSION['asmenys']['sort'] == 'pareigos') and ($_SESSION['asmenys']['order'] == 'DESC')) echo '_selected'; ?>.gif" border="0"></a>
		</td>
		<td nowrap>
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=vartotojo_vardas&order=ASC"><img src="style/down<? if (($_SESSION['asmenys']['sort'] == 'vartotojo_vardas') and ($_SESSION['asmenys']['order'] == 'ASC')) echo '_selected'; ?>.gif" border="0"></a>
				&nbsp;Vartotojo vardas
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=vartotojo_vardas&order=DESC"><img src="style/up<? if (($_SESSION['asmenys']['sort'] == 'vartotojo_vardas') and ($_SESSION['asmenys']['order'] == 'DESC')) echo '_selected'; ?>.gif" border="0"></a>
		</td>
		<td nowrap>
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=slaptazodis&order=ASC"><img src="style/down<? if (($_SESSION['asmenys']['sort'] == 'slaptazodis') and ($_SESSION['asmenys']['order'] == 'ASC')) echo '_selected'; ?>.gif" border="0"></a>
				&nbsp;Slaptazodis
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=slaptazodis&order=DESC"><img src="style/up<? if (($_SESSION['asmenys']['sort'] == 'slaptazodis') and ($_SESSION['asmenys']['order'] == 'DESC')) echo '_selected'; ?>.gif" border="0"></a>
		</td>
		<td nowrap>
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=lygis&order=ASC"><img src="style/down<? if (($_SESSION['asmenys']['sort'] == 'lygis') and ($_SESSION['asmenys']['order'] == 'ASC')) echo '_selected'; ?>.gif" border="0"></a>
				&nbsp;Lygis
			<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=lygis&order=DESC"><img src="style/up<? if (($_SESSION['asmenys']['sort'] == 'lygis') and ($_SESSION['asmenys']['order'] == 'DESC')) echo '_selected'; ?>.gif" border="0"></a>
		</td>
	</tr>
	
	<?
	
	$query = "SELECT * FROM asmenys ORDER BY ".$_SESSION['asmenys']['sort']." ".$_SESSION['asmenys']['order'];
	$result = $database->Query($query);
	$rows = mysqli_num_rows($result);
	
	for ($i = 0; $i < $rows; $i++)
	{
		$row = mysqli_fetch_assoc($result);
		?>
		<form name="project" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
		<input type="hidden" name="do" value="delete">
	
		<tr class="list-cell">
			<td nowrap align="left"><input type="checkbox" name="delete[]" value="<?= $row['asmens_id']; ?>"></td>
			<td nowrap align="left"><?= $row['vardas']; ?></td>
			<td nowrap align="left"><?= $row['pavarde']; ?></td>
			<td nowrap align="left"><?= $row['pareigos']; ?></td>
			<td nowrap align="left"><?= $row['vartotojo_vardas']; ?></td>
			<td nowrap align="left"><?= $row['slaptazodis']; ?></td>
			<td nowrap align="left"><?= $row['lygis']; ?></td>
		</tr>
		
		</form>
		<?
	}
	?>
	
	</table>
	<?
}