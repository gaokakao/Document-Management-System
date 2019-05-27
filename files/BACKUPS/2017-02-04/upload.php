<?php


if ($_FILES["Upload"]["tmp_name"] === "" )

{

echo '<div align="center"><br><br>Nepasirinkote Failų!<br><br>';

if ($_POST["dest"] === "users")
{
    echo "<button type='button' onclick=window.location='/private.php'>Grįžti</button>";
}
if ($_POST["dest"] === "shared")
{
    echo "<button type='button' onclick=window.location='/shared.php'>Grįžti</button>";
}

exit(1);

}







session_start();

if ($_POST["dest"] === "users")
{

		$path = $_SESSION["private"];
}

if ($_POST["dest"] === "shared")
{

		$path = $_SESSION["shared"];
}




$filename = $path . "\\";

$filename = $filename . $_FILES['Upload'] ['name'];

$result = move_uploaded_file ($_FILES['Upload'] ['tmp_name'], $filename);


if ($result)

{

if ($_POST["dest"] === "users")
{
header("location:https:/private.php");
}
if ($_POST["dest"] === "shared")
{
header("location:https:/shared.php");
}


}







else
{
echo '<div align="center"><br><br>Nepavyko įkelti failo!<br><br>';


if ($_POST["dest"] === "users")
{
    echo "<button type='button' onclick=window.location='/private.php'>Grįžti</button>";
}
if ($_POST["dest"] === "shared")
{
    echo "<button type='button' onclick=window.location='/shared.php'>Grįžti</button>";
}

}




?>