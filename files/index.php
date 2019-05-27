<?



session_start();

if ( isset($_SESSION["user"]) )

{
header("location:https:/private.php");

}

else 
	
	{
echo '

<!DOCTYPE html>
<html>
<head>
<title>Failai</title>
<meta charset="utf-8">

<style>

}input[type=button] 

{
    width: 8em;  height: 2em;
}


html,body 
{
  height:100%;
  width:100%;
  margin:0;
  font-size: medium;
}
body 
{
  display:flex;
}
form 
{
  margin:auto;
}

.container 
{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
}

span.nobr 
{
	white-space: nowrap; 
}

#login
    {
     font-size:18pt;
     
     width:350px;
    }

</style>

</head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<html>

<body align="center">

<div class="container">
<br>

<div style="float: left; " align="center">   </div>

<div class="login">

	<form action="/start.php" method="post">
	
<span align="left"> <img src="klinikos.jpg" style="width: 100; height:100px "> </span>
	<h1 align="center">  Santa Failai </h1>



<ul style="list-style-type: none;">
  <li><input type="text" name="user" placeholder="Naudotojo vardas" id="login" autofocus></li> 
  <li><input type="password" name="pass" placeholder="Slaptažodis" id="login" ></li>
  <li><button type="submit" style ="width: 8em;  height: 2em;" >Pirmyn</button></li> 
</ul>

	</form>

</div>



</body>
</html>
';
}

?>