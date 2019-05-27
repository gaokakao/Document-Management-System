<?



session_start();

if ( isset($_SESSION["user"]) )


header("location:http:/private.php");

else 
echo '

<!DOCTYPE html>
<html>
<head>
<title>Failai</title>
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


<form action="/start.php" method="post">
<ul style="list-style-type: none;">
  <li>Vartotojas: <input type="text" name="user" size="30" maxlength="30" autofocus></li> 
  <li>Slaptažodis: <input type="password" name="pass" size="30" maxlength="30"></li>
  <li><button type="submit" >Užeiti</button></li> 
</ul>
</form>


</div>

</body>
</html>
';

?>