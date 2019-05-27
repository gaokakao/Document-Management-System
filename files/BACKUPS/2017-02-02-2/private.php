<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Santa Failai</title>
  <link rel="stylesheet" href="style.css">
  
</head>

<body>

  <div id="container">
  

	<div align="left">		<input type="button" value="PRADŽIA"  onclick="window.location = '/choose.php';">		</div>
	<div align="right">		<input type="button" value="ATSIJUNGTI"  onclick="window.location = '/logout.php';">		</div>
    
	

    <table class="sortable">

      <thead>
        <tr>
          <th>Filename</th>
          <th>Type</th>
          <th>Size <small>(bytes)</small></th>
          <th>Date Modified</th>
        </tr>
      </thead>
      <tbody>
      <?php
	  
	  
session_start();

//var_dump ($_SESSION);


if ( !(isset($_SESSION["user"])) ||   ($_SESSION["user"] == "")  )  		// check for user coockie  :)
	
	{
//header("location:http:/index.php");
	}

	
	//var_dump ($_SESSION);  


$server = "\\\\santa.lt\\users\\";


$path = $server. $_SESSION["user"];   // default path for every user



// check for path coockie
if (isset($_SESSION["private"]) )
{

if ($_SESSION["private"] == "" )

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
 $path = $server .  $_SESSION["private"];
}		



$username = strpos($path, $_SESSION["user"]);

if (  $username == 0 )
{

	$path = $server. $_SESSION["user"];
	$_SESSION["private"] = $path;

//header("location:http:/index.php");

$user = $_SESSION["user"];

echo "user: $user<br><br><br>";
echo "server: $server<br><br><br>";
echo "Pataisytas path ==> $path <br>";

}




if ( isset($_GET['up']) )	// going UP  :) ^^
{

	$path = dirname ($_SESSION["private"]);
$_SESSION["private"] = $path;

}


if  ( isset($_GET["dir"]) )  // useris pakeite direktorija
{

$path = $path . "\\" . $_GET["dir"];
$_SESSION["private"] = $path;
}


$result = opendir($path); // Testinam Path

//var_dump ($result);

 if ( !$result )

{
 
$path = $server. $_SESSION["user"]; 
$_SESSION["private"] = $path;

//header("location:http:/index.php");

}



// apsauga, kad neiseitu i Root root users Direktorija
if ($path == "\\\santa.lt\users")
{
	$path = $server. $_SESSION["user"]; 
	//header("location:http:/index.php");
}	  






 
 
 



 
	  // Opens directory
        $dir=opendir($path);
        
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
////////////////////	
////////////////////	
// FUNCTIONS
////////////////////	
////////////////////	
		
		
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
		
////////////////////	
////////////////////	
////////////////////	
////////////////////	

		
		
		
		
		$pwd = currentdir ($path);
		
		//echo " <h1> $pwd </h1>";
		
		
		
////////////////////	
////////////////////	

        // MAIN WHILE LOOP
        while($file=readdir($dir)) 
		{
   
$name = $file;

$full = $path . "\\" . $file;

          
          if ( is_dir($full) )	// Direktorija
		  {
			  
			  
				  $modtime=date("Y-m-d", filemtime($full));
			  
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
			  

	  $modtime=date("Y-m-d", filemtime($full));
			  
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
          $size=number_format(filesize($full));
          
		  
		  
          // Gets Date Modified Data
				  $modtime=date("Y-m-d", filemtime($full));
			  
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
			  
            $class="file";

		$filename= substr($name, 0, strpos($name, '.'));
			
		         print("
          <tr class='$class'>
            <td><a href='/download.php?file=$name'> <img src='images/download.png' style='width=15px; height:15px;' >  $filename</a></td>
            <td><a href='/download.php?file=$name'>$extn</a></td>
            <td><a href='/download.php?file=$name'>$size</a></td>
            <td sorttable_customkey='$timekey'><a href='/download.php?file=$name'>$modtime</a></td>
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