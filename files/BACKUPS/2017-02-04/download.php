<?

session_start();

//var_dump($_GET); echo "<br>";



$filename = $_GET["file"];  // filename

$source = $_GET["s"];		// private or shared disk =>  p - private  s - shared

if ($source == "p" ) // Private Disk
{
$path = $_SESSION["private"];
}


if ($source == "s" ) // Shared Disk
{
$path = $_SESSION["shared"];
}


$full = $path. "\\" . $filename;

//echo "Full path is => $full";

$file = @fopen($full, "rb");

set_time_limit(0);

header("Content-Disposition: attachment; filename=\"$filename\"");

while(!feof($file)) 

{
	print(@fread($file, 1024*8));
	ob_flush();
	flush();
}

?>