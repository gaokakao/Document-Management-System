<!doctype html>
<html>

<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Bendras Diskas</title>
  <link rel="stylesheet" href="style.css">
  
</head>

<body>

  <div id="container">

 
	<div style=" float: right;
  border-style: solid;
    border-color: blue; ">

<input type="button" value="P DISKAS"  onclick="window.location = '/private.php';">	

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
		<input type="hidden" name="dest" value="shared">


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

if ( !(isset($_SESSION["user"]))  )  // check for user coockie yum :)
	
	{
//header("location:https:/index.php");
	}

	

$server = "\\\\santa.lt\\bendras\\";
$path = $server; 


if ( isset($_SESSION["shared"]) )

	{
	
	$path =  $_SESSION["shared"];
	}
	
	else

	{  

	$_SESSION["shared"] = $path;

	}


if ( isset($_GET['up']) )	// going UP  :) ^^
{

	$path = dirname ($_SESSION["shared"]);
	$_SESSION["shared"] = $path;
	header("location:https:/shared.php");


}



if  ( isset($_GET["dir"]) )  // useris pakeite direktorija
{

	$path = $_SESSION["shared"] . "\\" . $_GET["dir"];

}


$result = @opendir($path); // Testinam Path

 if ($result )
{


$_SESSION["shared"] = $path;

}

else
{
	echo "blogas rezultatas!<br>";
 
$path =  $_SESSION["shared"];

//echo" Taisome path į : &nbsp; $path<br>";

header("location:https:/shared.php");

}






        // Finds extensions of files
        function findexts ($filename)
		{
			$parts = pathinfo($filename);
			if (isset ($parts['extension']) )
			{ return $parts['extension']; }
		else { return ""; }
	
        }
 
 
 
         // Get Current Directory Name
        function currentdir ($path)
		{
			$parts = explode("\\", $path);
			return end($parts);
	
        }


		function human_filesize($bytes, $decimals = 2) 
{
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}



 
	  // Opens directory
        $dir=opendir($path);
        
		
		
		
		$pwd = currentdir ($path);
		
		//echo " <h1> $pwd </h1>";
		
		
		
		
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
			<td><a href='/shared.php?up=1'> <img src='images/up.png' style='width=15px; height:15px;'></a></td>
            <td><a href='/shared.php?up=1'></a></td>
            <td><a href='/shared.php?up=1'></a></td>
            <td sorttable_customkey='$timekey'><a href='/shared.php?up=1'></a></td>
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
            <td><a href='/shared.php?dir=$name'>  <img src='images/folder.png' style='width=15px; height:15px;' > $name</a></td>
            <td><a href='/shared.php?dir=$name'></a></td>
            <td><a href='/shared.php?dir=$name'></a></td>
            <td sorttable_customkey='$timekey'><a href='/shared.php?dir='$name'></a></td>
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
            case "png": $extn="PNG Image"; break;
            case "jpg": $extn="JPEG Image"; break;
            case "svg": $extn="SVG Image"; break;
            case "gif": $extn="GIF Image"; break;
            case "ico": $extn="Windows Icon"; break;
            
            case "txt": $extn="Text File"; break;
            case "log": $extn="Log File"; break;
            case "htm": $extn="HTML File"; break;
            case "php": $extn="PHP Script"; break;
            case "js": $extn="Javascript"; break;
            case "css": $extn="Stylesheet"; break;
            case "pdf": $extn="PDF Document"; break;
            
            case "zip": $extn="ZIP Archive"; break;
            case "bak": $extn="Backup File"; break;
            
            default: $extn=ucwords($extn)." File"; break;
          }

		$extn = str_ireplace("File", "", $extn);


			  
            $class="file";
			
		         print("
          <tr class='$class'>
            <td><a href='/download.php?s=s&file=$name'><img src='images/download.png' style='width=15px; height:15px;' >$name</a></td>
            <td><a href='/download.php?s=s&file=$name'>$extn</a></td>
            <td><a href='/download.php?s=s&file=$name'>$size</a></td>
            <td sorttable_customkey='$timekey'><a href='/download.php?s=s&file=$name'>$modtime</a></td>
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