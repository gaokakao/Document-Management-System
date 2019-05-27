<!DOCTYPE html>
<html>
<head>
<title>Santa Failai</title>
<meta charset="utf-8">
<style>

html,body {
  height:100%;
  width:100%;
  margin:0;
  font-size: medium;
}
body {
  display:flex;
}
form {
  margin:auto;
}

.container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
}

span.nobr { white-space: nowrap; }

</style>

</head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
<body align="center">

<?

session_start();
var_dump ($_SESSION);

?>

<div class="container">
	<div align="right">		<input type="button" value="ATSIJUNGTI"  onclick="window.location = '/logout.php';">		<br><br><br></div>

<input type="button" value=" P DISKAS"  onclick="window.location = '/private.php';">

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value=" R DISKAS"  onclick="window.location = '/shared.php';">

</div>

</body>
</html>

