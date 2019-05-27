<?

session_start();


if (isset ($_SESSION["private"]) )
{
$path = $_SESSION["private"];
}

if (isset ($_SESSION["shared"]) )
{
$path = $_SESSION["shared"];
}

$filename = $_GET["file"];


$full = $path. "\\" . $filename;


$file = @fopen($full, "rb");

set_time_limit(0);
 header("Content-Disposition: attachment; filename=\"$filename\"");


while(!feof($file)) {
    print(@fread($file, 1024*8));
    ob_flush();
    flush();
}

?>