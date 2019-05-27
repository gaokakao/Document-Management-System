<?
if (isset($_SESSION['error']))
{
	?>
	<span style="color: #FF0000; font-weight: bold;"><?= $_SESSION['error']; ?></span>
	<br>
	<?
	unset($_SESSION['error']);
}
?>

<table width="100%" cellpadding="4" cellspacing="1" bgcolor="#AAAAAA">
<form name="vartotojai" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
<tr bgcolor="#DDDDDD" align="center">
	<?
		if ($_SESSION['lygis'] == 'admin')
		{
			?>
			<td width="18">&nbsp;</td>
			<td width="18">&nbsp;</td>
			<?
		}
	?>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=vardas&order=ASC"><img src="style/down<? if (($_SESSION['vartotojai']['sort'] == 'vardas ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Vardas
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=vardas&order=DESC"><img src="style/up<? if (($_SESSION['vartotojai']['sort'] == 'vardas DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pavarde&order=ASC"><img src="style/down<? if (($_SESSION['vartotojai']['sort'] == 'pavarde ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Pavardė
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pavarde&order=DESC"><img src="style/up<? if (($_SESSION['vartotojai']['sort'] == 'pavarde DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pareigos&order=ASC"><img src="style/down<? if (($_SESSION['vartotojai']['sort'] == 'pareigos ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Pareigos
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pareigos&order=DESC"><img src="style/up<? if (($_SESSION['vartotojai']['sort'] == 'pareigos DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=lygis&order=ASC"><img src="style/down<? if (($_SESSION['vartotojai']['sort'] == 'lygis ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Vartotojo tipas
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=lygis&order=DESC"><img src="style/up<? if (($_SESSION['vartotojai']['sort'] == 'lygis DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=email&order=ASC"><img src="style/down<? if (($_SESSION['vartotojai']['sort'] == 'email ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Elektroninio pašto adresas
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=email&order=DESC"><img src="style/up<? if (($_SESSION['vartotojai']['sort'] == 'email DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=vartotojo_vardas&order=ASC"><img src="style/down<? if (($_SESSION['vartotojai']['sort'] == 'vartotojo_vardas ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Vartotojo vardas
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=vartotojo_vardas&order=DESC"><img src="style/up<? if (($_SESSION['vartotojai']['sort'] == 'vartotojo_vardas DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
</tr>

<?

$query = "SELECT * FROM asmenys ORDER BY ".$_SESSION['vartotojai']['sort'];
$result = $database->Query($query);
$rows = mysqli_num_rows($result);

while ($row = mysqli_fetch_assoc($result))
{
	?>
	<tr bgcolor="#FFFFFF">
		<?
			if ($_SESSION['lygis'] == 'admin')
			{
				?>
				<td style="padding-right: 5px;"><a href="<?= $_SERVER['PHP_SELF']; ?>?action=edit&id=<?= $row['asmens_id']; ?>"><img src="style/vartotojai_edit.gif" alt="Redaguoti šį įrašą" border="0"></a></td>
				<?
				if ($_SESSION['asmens_id'] != $row['asmens_id'])
				{
					?>
					<td style="padding-right: 5px;"><a href="#" onclick="if (confirm('Ar tikrai pašalinti ši vartotoją?')) window.location='<?= $_SERVER['PHP_SELF']; ?>?action=delete&id=<?= $row['asmens_id']; ?>'"><img src="style/vartotojai_delete.gif" alt="Pašalinti šį įrašą" border="0"></a></td>
					<?
				}
				else
				{
					?>
					<td>&nbsp;</td>
					<?
				}
			}
		?>
		<td nowrap><?= $row['vardas']; ?></td>
		<td nowrap><?= $row['pavarde']; ?></td>
		<td nowrap><?= $row['pareigos']; ?></td>
		<td nowrap><?= $saugumas[$row['lygis']]; ?></td>
		<td nowrap><?= $row['email']; ?></td>
		<td nowrap><?= $row['vartotojo_vardas']; ?></td>
	</tr>
	<?
}
?>

</form>
</table>