<?

session_start();


$path = $_SESSION["path"];


$filename = $_GET["file"];


$full = $path . "\\" . $filename;


 header("Content-Disposition: attachment; filename=\"$filename\"");
set_time_limit(0);
$file = @fopen($full, "rb");



while(!feof($file)) {
    print(@fread($file, 1024*8));
    ob_flush();
    flush();
}


?>