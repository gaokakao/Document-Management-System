<?php

//session_start();

//var_dump ($_SESSION);
//var_dump ($_GET);


session_start();

if ( !(isset($_SESSION["user"])) ||   ($_SESSION["user"] == "")  )  		// check for user coockie  :)
{ header("location:https:/index.php"); }

$server = "\\\\santa.lt\\users\\";

$path = $server. $_SESSION["user"];   // default path for every user


if (isset($_SESSION["private"]) ) 	// check for path coockie
{

if ($_SESSION["private"] === "" )

	{
	$path = $server. $_SESSION["user"];
	$_SESSION["private"] = $path; 
	}

	else
	{
		$path = $_SESSION["private"];

	}
}

else

{
 $path = $server .  $_SESSION["user"];
$_SESSION["private"] = $path;
}

$username = strpos($path, $_SESSION["user"]);

if (  $username == 0 )
{

	$path = $server. $_SESSION["user"];
	$_SESSION["private"] = $path;
}



if  ( isset($_GET["new"]) )  // naujos  direktorijos vardas
{
	$newdir =  $path . "\\" . $_GET["new"];
	
	$mewdir = urlencode  (utf8_encode ($newdir));
	//echo $newdir;
	
	$result = mkdir($newdir);
	
//	var_dump($result);


}

if( $result )

{
echo  "<script type='text/javascript'>";


echo " window.onunload = refreshParent;
    function refreshParent() 
	{
        window.opener.location.reload();
    } ";
}
echo  "<script type='text/javascript'>";
echo "window.close();";
echo "</script>";


	
?>