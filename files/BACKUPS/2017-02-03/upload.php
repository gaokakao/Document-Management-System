<?php

 //echo "FILES:";
 //var_dump ($_FILES);

 echo "<br><br><br>";

session_start();
// echo "SESSION:";
// var_dump ($_SESSION);

// echo "<br><br><br>";
if ($_POST["dest"] === "users")
{

		$path = $_SESSION["private"];
}

if ($_POST["dest"] === "bendras")
{

		$path = $_SESSION["shared"];
}


$path .= "\\";

//echo "$path <br>";

$count = 0;

	foreach ($_FILES['Upload']['tmp_name'] as $f => $name) 

{     
	var_dump ($f);
	if ($_FILES['Upload']['error'][$f] == 4) 
	{
	 continue; // Skip file if any error found
	}	       
	if ($_FILES['Upload']['error'][$f] == 0)
	{
	}
		else // No error found! Move uploaded files 
		
	{
	
		$result = move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name);
		
	var_dump ($result);
		if ($result)  $count++; // Number of successfully uploaded file

	}

}

echo $count;





?>