<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Asmeninis Diskas</title>
  <link rel="stylesheet" href="style.css">
  
</head>

<body>


  <div id="container">

 
	<div style=" float: right;
  border-style: solid;
    border-color: blue; ">

<input type="button" value="R DISKAS"  onclick="window.location = '/shared.php';">	

		<input type="button" value="ATSIJUNGTI"  onclick="window.location = '/logout.php';">		



</div>




	<div style=" float: left; ">


<div style="
    border-style: solid;
    border-color: green;


">

	<form action="upload.php" method="post" enctype="multipart/form-data">
	
		<input type="file" name="Upload" value="Upload" id="Upload">



		<input type="submit" value="IKELTI">

		<input type="hidden" name="dest" value="users">


	</form>

</div>

 <div id="container"> 
	

    <table class="sortable">

      <thead>
        <tr>
          <th>Filename</th>
          <th>Type</th>
          <th>Size</th>
          <th>Date Modified</th>
        </tr>
      </thead>
      <tbody>
      <?php
	  
	  
session_start();


if ( !(isset($_SESSION["user"])) ||   ($_SESSION["user"] == "")  )  		// check for user coockie  :)
	
	{
header("location:http:/index.php");
	}



$server = "\\\\santa.lt\\users\\";


$path = $server. $_SESSION["user"];   // default path for every user



// check for path coockie
if (isset($_SESSION["private"]) )
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


$user = $_SESSION["user"];

//echo "user: $user<br><br><br>";
//echo "server: $server<br><br><br>";
//echo "Pataisytas path ==> $path <br>";

}




if ( isset($_GET['up']) )	// going UP  :) ^^
{

	$path = dirname ($_SESSION["private"]);
	$_SESSION["private"] = $path;
	header("location:http:/private.php");


}










if  ( isset($_GET["dir"]) )  // useris pakeite direktorija
{

	$path = $_SESSION["private"] . "\\" . $_GET["dir"];

//echo"TURIME GET: ";
//echo $_GET["dir"];
//echo "<br><br>visas path gaunasi: &nbsp;&nbsp;&nbsp;$path<br><br><br>";

}


$result = @opendir($path); // Testinam Path

//echo "testo rezultatas: ";
//var_dump ($result); echo"<br><br>";

 if ($result )
{
//echo "geras rezultatas!";

$_SESSION["private"] = $path;

}

else
{
	echo "blogas rezultatas!<br>";
 
$path =  $_SESSION["private"];

//echo" Taisome path į : &nbsp; $path<br>";

header("location:http:/private.php");

}




// apsauga, kad neiseitu i Root root users Direktorija
if ($path == "\\\santa.lt\users")
{
	$path = $server. $_SESSION["user"]; 
	//header("location:http:/index.php");
}	  


	  // Opens directory
        $dir=@opendir($path);
        
		


		
	// Get Current Directory Name
        function currentdir ($path)
		{
			$parts = explode("\\", $path);
			return end($parts);
	
        }		
		

	// Finds extensions of files
        function findexts ($filename)
		{
			$parts = pathinfo($filename);
			if (isset ($parts['extension']) )
			{ return $parts['extension']; }
		else { return ""; }
	
        }		
		
		function human_filesize($bytes, $decimals = 2) 
{
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}





	
		$pwd = basename ($path);
		
		echo "
<div style='float:left;'>

 <h1> $pwd </h1>

</div>

";
		
		



        // MAIN WHILE LOOP
        while($file=readdir($dir)) 
		{
   
$name = $file;

$full = $path . "\\" . $file;

          
          if ( is_dir($full) )	// Direktorija
		  {
			  
			  
				  $modtime=date("Y-m-d", @filemtime($full));
			  
			  $timekey = $modtime;
	  
	  			  
			  
			  
			if ($name==".")   // taskelis .
		{
			continue;
		}

		if ($name=="..")	  // du taskeliai ..   ^ aukstyn direktorija
		  {
			  
				if ($path == $server . $_SESSION["user"] )
				{   continue; }
			  
				else
				{
			  
			  $name ="UP";
			  
			   print("
			<tr class=dir>
			<td><a href='/private.php?up=1'> <img src='images/up.png' style='width=17px; height:17px;'></a></td>
            <td><a href='/private.php?up=1'></a></td>
            <td><a href='/private.php?up=1'></a></td>
            <td sorttable_customkey='$timekey'><a href='/private.php?up=1'></a></td>
          </tr>");
				}
			  
		   }
			 
			  
		else			// visos kitos direktorijos
			{			
			  

	  $modtime=date("Y-m-d", @filemtime($full));
			  
		$timekey = $modtime;
	  
	  					  
            $extn=""; 
            $size=""; 
            $class="dir";
			
			    print("
          <tr class=dir>
            <td><a href='/private.php?dir=$name'>  <img src='images/folder.png' style='width=17px; height:17px;' > $name</a></td>
            <td><a href='/private.php?dir=$name'></a></td>
            <td><a href='/private.php?dir=$name'></a></td>
            <td sorttable_customkey='$timekey'><a href='/private.php?dir='$name'></a></td>
          </tr>");
		

			}
		  
		  }
		  
		  
			else 								// Failas
		  
		  {
			  
			  
	
          // Gets Extensions 
          $extn=findexts($full); 
          
		  
	

          // Gets file size 
          $bytes=@filesize($full);
          
		  
$size  = human_filesize ($bytes,0);

		  
          // Gets Date Modified Data
				  $modtime=date("Y-m-d", @filemtime($full));
			  
			  $timekey = $modtime;
	  
	  
	  

	  // Prettifies File Types, add more to suit your needs.
          switch ($extn)
		  {
            case "png": $extn="Image"; break;
            case "jpg": $extn="Image"; break;
            case "svg": $extn="Image"; break;
            case "gif": $extn="Image"; break;
            case "ico": $extn="Icon"; break;
            
            case "txt": $extn="Text"; break;
            case "log": $extn="Log"; break;
            case "htm": $extn="HTML"; break;
            case "php": $extn="PHP"; break;
            case "js": $extn="Javascript"; break;
            case "css": $extn="Stylesheet"; break;
            case "pdf": $extn="PDF"; break;
            
            case "zip": $extn="Archive"; break;
            case "bak": $extn="Backup"; break;
            case "bak": $extn="Backup"; break;
            
            default: $extn=ucwords($extn); break;
          }
			if ($extn === "" ) $extn = "File";
			  

		$extn = str_ireplace("File", "-", $extn);


            $class="file";

		$filename= substr($name, 0, strpos($name, '.'));
			
		         print("
          <tr class='$class'>
            <td><a href='/download.php?s=p&file=$name'> <img src='images/download.png' style='width=15px; height:15px;' >  $filename</a></td>
            <td><a href='/download.php?s=p&file=$name'>$extn</a></td>
            <td><a href='/download.php?s=p&file=$name'>$size</a></td>
            <td sorttable_customkey='$timekey'><a href='/download.php?s=p&file=$name'>$modtime</a></td>
          </tr>");
		  
		  }
			
			

		 
		}  // main While loop
		
	       // Closes directory
        closedir($dir);
        

		
      ?>

      </tbody>
    </table>
      
  </div>
  
</body>

</html>