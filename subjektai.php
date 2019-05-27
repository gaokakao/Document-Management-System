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
<form name="subjektai" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
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
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pavadinimas&order=ASC"><img src="style/down<? if (($_SESSION['subjektai']['sort'] == 'pavadinimas ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Pavadinimas
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=pavadinimas&order=DESC"><img src="style/up<? if (($_SESSION['subjektai']['sort'] == 'pavadinimas DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=adresas&order=ASC"><img src="style/down<? if (($_SESSION['subjektai']['sort'] == 'adresas ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Adresas
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=adresas&order=DESC"><img src="style/up<? if (($_SESSION['subjektai']['sort'] == 'adresas DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
	<td nowrap>
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=kodas&order=ASC"><img src="style/down<? if (($_SESSION['subjektai']['sort'] == 'kodas ASC')) echo '_selected'; ?>.gif" border="0"></a>
			&nbsp;Kodas
		<a href="<?= $_SERVER['PHP_SELF']; ?>?sort=kodas&order=DESC"><img src="style/up<? if (($_SESSION['subjektai']['sort'] == 'kodas DESC')) echo '_selected'; ?>.gif" border="0"></a>
	</td>
</tr>

<?

$query = "SELECT * FROM subjektai ORDER BY ".$_SESSION['subjektai']['sort'];
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
				<td style="padding-right: 5px;"><a href="<?= $_SERVER['PHP_SELF']; ?>?action=edit&id=<?= $row['subjekto_id']; ?>"><img src="style/subjektai_edit.gif" alt="Redaguoti šį įrašą" border="0"></a></td>
				<td style="padding-right: 5px;"><a href="#" onclick="if (confirm('Ar tikrai pašalinti ši subjektą?')) window.location='<?= $_SERVER['PHP_SELF']; ?>?action=delete&id=<?= $row['subjekto_id']; ?>'"><img src="style/subjektai_delete.gif" alt="Pašalinti šį įrašą" border="0"></a></td>
				<?
			}
		?>
		<td nowrap><?= $row['pavadinimas']; ?></td>
		<td nowrap><?= $row['adresas']; ?></td>
		<td nowrap><?= $row['kodas']; ?></td>
	</tr>
	<?
}
?>

</form>
</table>