<!DOCTYPE html>
<html>
<head>

  <link rel="stylesheet" href="style.css">


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

}input[type=button] 

{
    width: 8em;  height: 2em;
}



</style>

</head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
<body align="center">


<div class="container">

<?php

$user = $_POST["user"];
$pass= $_POST["pass"];

if  ( ($user == "") && ($pass == "")  )
{

    echo "<br>Įveskite Vartotojo Vardą ir Slaptažodį!<br><br>";
    echo "<input type='button' value='Grįžti' onclick=window.location='/index.php'> </button>";
	exit(1);
}


if  ( ($user == "")  )
{

    echo "<br>h2>Įveskite Vartotojo Vardą!<br><br>/h2>";
    echo "<input type='button' value='Grįžti' onclick=window.location='/index.php'> </button>";
	exit(1);
}
if  ( ($pass == "")  )
{

    echo "<br> <h2> Įveskite Slaptažodį!</h2><br><br> ";
    echo "<input type='button' value='Grįžti' onclick=window.location='/index.php'></button>";
	exit(1);
}




ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);

$link = @ldap_connect('santa.lt'); // Your domain or domain 

//if(! $link) 

//{
    //echo "Could not connect to server - handle error appropriately<br>";
//}

//else

//{
//echo " Sucessfully connected to santa.lt kinda <br>";
//}

ldap_set_option($link, LDAP_OPT_DEBUG_LEVEL, 7);

@ldap_set_option($link, LDAP_OPT_PROTOCOL_VERSION, 3);

//echo "Now try to authenticate with credentials provided by user<br>";

$username = $user . "@santa.lt";

if (! @ldap_bind($link, $username, $pass))
{

    echo "<h2> Neteisingas Vartotojo Vardas arba Slaptažodis!</h2><br><br>";
    echo "<input type='button' value='Grįžti' onclick=window.location='/index.php'> </button>";
	exit(1);
}

else
{
//echo "Slaptažodis Teisingas<br>";

session_start();

$_SESSION["user"] = $user;


header("location:https:/private.php");


}


?>

</div>

</body>
</html>

