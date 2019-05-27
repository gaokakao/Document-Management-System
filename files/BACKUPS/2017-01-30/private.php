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


<div class="container">



<?

session_start();



var_dump($_SESSION);

echo "<br><br><br>";



$server = "\\\\mas01\\users\\";
$path = $server. $_SESSION["user"]; 


if ( !( isset($_SESSION["path"]) ) )
{ $_SESSION["path"] = $path; }

else { $path =  $_SESSION["path"]; }


$upper =  dirname ($_SESSION['path']);

//echo "<br><br>up dir => $upper";


if ( isset($_GET['up']) )	// going UP ^^
{
	$path = dirname ($_SESSION["path"]);
$_SESSION["path"] = $path;

}






if  ( isset($_GET["dir"]) )  // useris pakeite direktorija

{

$path = $path . "\\" . $_GET["dir"];
$_SESSION["path"] = $path;
}


$folder = opendir($path);

while (($file = readdir($folder)) !== false)	// Listiname direktorijos turini
{
if ( ( $file == "..") && ( $path !== $server.$_SESSION['user'] ) )
{
//echo "$server === $path";
echo "<a href='private.php?up=1'>";
echo '<img src="folder.png"';
echo "style='width:40px;height:40px;' ></a><br><br>";
}

if ( ($file !== ".") && ($file !== "..") )
{

$dir = is_dir ($path . "//" . $file);

	if ($dir)
		{
	
echo " <a href='private.php?dir=$file'<h3> $file </h3></a><br> ";		// direktorija, tai duodame linka eiti i direktorija
		}
	
	else 
		{	
echo "<a href='download.php?file=$file'> $file </a> <br>"; 		// failas, tai duodame download linka
		}
}


}  // while firektorijos listing ciklas


closedir($folder);

// Zi End :)



?>



</div>

</body>
</html>

