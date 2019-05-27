<?

require_once('./phpmailer/phpmailer.php');

ob_start();

$query = "SELECT * FROM sutartys WHERE sutarties_id = ".$_SESSION['new_id'];
$row = $database->QueryAssoc($query);

?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=<?= PAGE_CHARSET ?>">
<style>
<? include('./style/other/style.css'); ?>
</style>
</head>

<body>
<table cellpadding="4" cellspacing="1" bgcolor="#AAAAAA">
<tr bgcolor="#DDDDDD">
	<td colspan="2">
		<b>
		<?
		if (is_null($row['parent_id']))
		{
			echo 'Sutarčių registre įvesta naują sutartis';
		}
		else
		{
			$query = "SELECT numeris FROM sutartys WHERE sutarties_id = ".$row['parent_id'];
			$parent = $database->QueryAssoc($query);
			echo 'Sutarčių registre įvestas naujas sutarties Nr. '.$parent['numeris'].' priedas Nr. '.$row['numeris'];
		}
		?>
		</b>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right" bgcolor="#DDDDDD">Sutarties numeris:</td>
	<td nowrap><?= $row['numeris']; ?></td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right" bgcolor="#DDDDDD">Sutarties numeris pagal kitą šalį:</td>
	<td nowrap><?= $row['kitas_numeris']; ?></td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right" bgcolor="#DDDDDD">Sutarties kita šalis:</td>
	<td nowrap>
	<?
		$query = "SELECT pavadinimas FROM subjektai WHERE subjekto_id = ".$row['kita_salis'];
		$subjektas = $database->QueryAssoc($query);
		echo $subjektas['pavadinimas'];
	?>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right" bgcolor="#DDDDDD">Sutarties sudarymo data:</td>
	<td nowrap><?= $row['data']; ?></td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right" bgcolor="#DDDDDD">Sutarties galiojimo terminas:</td>
	<td nowrap>
	<?
		if ($row['terminas'] == '0000-00-00')
			echo 'Neterminuota';
		else if ($row['terminas'] == '1111-11-11')
			echo 'Iki šalių įsipareigojimų įvykdimo';
		else
			echo $row['terminas'];
	?>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right" bgcolor="#DDDDDD">Sutarties objektas:</td>
	<td nowrap><?= $row['objektas']; ?></td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right" bgcolor="#DDDDDD">Sutarties pobūdis:</td>
	<td nowrap><?= $row['pobudis']; ?></td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right" bgcolor="#DDDDDD">Sutarties tipas</td>
	<td nowrap><?= $row['tipas']; ?></td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right" bgcolor="#DDDDDD">Atsakingas asmuo:</td>
	<td nowrap>
	<?
		$query = "SELECT vardas, pavarde, pareigos FROM asmenys WHERE asmens_id = ".$row['atsakingas_asmuo'];
		$asmuo = $database->QueryAssoc($query);
		echo $asmuo['vardas'].' '.$asmuo['pavarde'].', '.$asmuo['pareigos'];
	?>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right" bgcolor="#DDDDDD">Sutartį pasirašęs asmuo:</td>
	<td nowrap>
	<?
		$query = "SELECT vardas, pavarde, pareigos FROM asmenys WHERE asmens_id = ".$row['pasirases_asmuo'];
		$asmuo = $database->QueryAssoc($query);
		echo $asmuo['vardas'].' '.$asmuo['pavarde'].', '.$asmuo['pareigos'];
	?>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right" bgcolor="#DDDDDD">Sutarties galiojimo požymis:</td>
	<td nowrap>
	<?
		if ($row['galiojimas'] == 'taip')
			echo 'Galiojanti';
		else
			echo 'Negaliojanti';
	?>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right" bgcolor="#DDDDDD">Struktūrinis objektas:</td>
	<td nowrap>
	<?
		if (!is_null($row['strukturinis_objektas']))
		{
			$query = "SELECT pavadinimas, adresas FROM objektai WHERE objekto_id = ".$row['strukturinis_objektas'];
			$objektas = $database->QueryAssoc($query);
			echo $objektas['pavadinimas'].', '.$objektas['adresas'];
		}
		else
		{
			echo 'Nenurodytas';
		}
	?>
	</td>
</tr>
<tr bgcolor="#FFFFFF">
	<td nowrap align="right" bgcolor="#DDDDDD">Komentaras:</td>
	<td nowrap><?= $row['komentaras']; ?></td>
</tr>
</table>

<?
if (!is_null($row['dokumentas']))
{
	?>
	<br>
	<p>Sutarties dokumentas prisegtas</p>
	<?
}
?>


</body>

</html>
<?

$html = ob_get_clean();

$mail = new PHPMailer();

$mail->IsSMTP();                                    	// set mailer to use SMTP
$mail->Host = 'smtpproxy.nafta.lt';						// specify main and backup server
$mail->SMTPAuth = false;     							// turn on SMTP authentication
$mail->Username = '';  									// SMTP username
$mail->Password = ''; 									// SMTP password

$mail->IsHTML(true);                                	// set email format to HTML

$mail->From = 'sutartys@ventus.lt';
$mail->FromName = 'Sutarčių registras';

$query = "SELECT * FROM asmenys WHERE lygis = 'special' OR lygis = 'admin'";
$result = $database->Query($query);

while ($emails = mysqli_fetch_assoc($result))
{
	if ((!is_null($emails['email'])) and ($emails['email'] != ''))
   		$mail->AddAddress($emails['email'], $emails['vardas'].' '.$emails['pavarde']);	                                    // add administrators and VIP
}

$query = "SELECT * FROM asmenys WHERE asmens_id = ".$row['atsakingas_asmuo'];
$email = $database->QueryAssoc($query);
$mail->AddAddress($email['email'], $email['vardas'].' '.$email['pavarde']);             // add responsible person

$objektas = (($row['objektas'] != '') ? ' "'.$row['objektas'].'"' : '');
if (is_null($row['parent_id']))
	$mail_subject = 'Pranešimas apie įvestą naują sutartį Nr. '.$row['numeris'].$objektas;
else
	$mail_subject = 'Pranešimas apie įvestą naują sutarties Nr. '.$parent['numeris'].' priedą Nr. '.$row['numeris'].$objektas;

$objektas = (($row['objektas'] != '') ? ' "'.$row['objektas'].'"' : '');
$mail->Subject = $mail_subject;
$mail->Body    = $html;
if (!is_null($row['dokumentas']))
	$mail->AddAttachment($row['dokumentas']);

$mail->Send();

?>