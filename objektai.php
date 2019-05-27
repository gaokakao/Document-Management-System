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
<form name="objektai" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
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
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pavadinimas&order=ASC"><img src="style/down<? if (($_SESSION['objektai']['sort'] == 'pavadinimas ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Pavadinimas
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pavadinimas&order=DESC"><img src="style/up<? if (($_SESSION['objektai']['sort'] == 'pavadinimas DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=adresas&order=ASC"><img src="style/down<? if (($_SESSION['objektai']['sort'] == 'adresas ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Adresas
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=adresas&order=DESC"><img src="style/up<? if (($_SESSION['objektai']['sort'] == 'adresas DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
</tr>

<?

$query = "SELECT * FROM objektai ORDER BY ".$_SESSION['objektai']['sort'];
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
				<td style="padding-right: 5px;"><a href="<?= $_SERVER['PHP_SELF']; ?>?action=edit&id=<?= $row['objekto_id']; ?>"><img src="style/objektai_edit.gif" alt="Redaguoti šį įrašą" border="0"></a></td>
				<td style="padding-right: 5px;"><a href="#" onclick="if (confirm('Ar tikrai pašalinti ši struktūrinį objektą?')) window.location='<?= $_SERVER['PHP_SELF']; ?>?action=delete&id=<?= $row['objekto_id']; ?>'"><img src="style/objektai_delete.gif" alt="Pašalinti šį įrašą" border="0"></a></td>
				<?
			}
		?>
		<td nowrap><?= $row['pavadinimas']; ?></td>
		<td nowrap><?= $row['adresas']; ?></td>
	</tr>
	<?
}
?>

</form>
</table>