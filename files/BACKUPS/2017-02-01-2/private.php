<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Santa Failai</title>
  <link rel="stylesheet" href="style.css">
  <script src="sorttable.js"></script>
</head>

<body>

  <div id="container">
  
    <h1>Santa Failai</h1>
    
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

if ( !(isset($_SESSION["user"]))  )
	
header("location:http:/index.php");


$server = "\\\\mas01\\users\\";
$path = $server. $_SESSION["user"]; 


if ( !( isset($_SESSION["path"]) ) )
{ $_SESSION["path"] = $path; }

else { $path =  $_SESSION["path"]; }




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


// apsauga, kad neiseitu i Root Mas01 Direktorija
if ($path == "\\\mas01\users")
{
	$path = $server. $_SESSION["user"]; 
}	  
	  
	  // Opens directory
        $myDirectory=opendir($path);
        
        // Gets each entry
        while($entryName=readdir($myDirectory)) 
		{
          $dirArray[]=$entryName;
        }
        
		
		
		
		
		
		
		
		
		
		
		
        // Finds extensions of files
        function findexts ($filename)
		{
			$parts = pathinfo($filename);
			if (isset ($parts['extension']) )
			{ return $parts['extension']; }
		else { return ""; }
	
        }
        
        // Closes directory
        closedir($myDirectory);
        
        // Counts elements in array
        $indexCount=count($dirArray);
        
        // Sorts files
        sort($dirArray);
        
		
		
		
		
		
		
		
		
		$timekey = "";
		
		
		
        // Loops through the array of files
        for($index=0; $index < $indexCount; $index++) 
		{


          
          // Gets File Names
          $name=$dirArray[$index];
          $namehref=$dirArray[$index];
          
		  
		  

          
          if ( is_dir($dirArray[$index]) )	// Direktorija
		  {
			  
			  
			  
			  
			if ($name==".")   // taskelis .
		{
			continue;
		}

		if ($name=="..")	  // du taskeliai ..   ^ aukstyn direktorija
		  {
			  $name ="UP";
			  $namehref = "private.php?up=1";
			  
			    print("
          <tr class=dir>
            <td><a href='/private.php?up=1'>$name</a></td>
            <td><a href='/private.php?up=1'></a></td>
            <td><a href='/private.php?up=1'></a></td>
            <td sorttable_customkey='$timekey'><a href='/private.php?up=1'></a></td>
          </tr>");
			 
		   }
			 
			  
		else			// visos kitos direktorijos
			{			
			  
			  
		$namehref = "private.php?dir=$name"; 
			  
            $extn=""; 
            $size=""; 
            $class="dir";
			
			    print("
          <tr class=dir>
            <td><a href='/private.php?dir=$name'>$name</a></td>
            <td><a href='/private.php?dir=$name'></a></td>
            <td><a href='/private.php?dir=$name'></a></td>
            <td sorttable_customkey='$timekey'><a href='/private.php?dir=$name'></a></td>
          </tr>");
		

			}
		  
		  }
		  
		  
		  
		  
		  
			else 								// Failas
		  
		  {
			  
			  
			  
			  
			  
			  
			  
			  




          // Gets Extensions 
          $extn=findexts($dirArray[$index]); 
          
		  
		  
          // Gets file size 
          $size=number_format(filesize($dirArray[$index]));
          
		  
		  
          // Gets Date Modified Data
				  $modtime=date("Y-m-d", filemtime($dirArray[$index]));
			  
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
            
            default: $extn=strtoupper($extn)." File"; break;
          }

			  
            $class="file";
			
		         print("
          <tr class='$class'>
            <td><a href='/download.php?file=$name'>$name</a></td>
            <td><a href='/download.php?file=$name'>$extn</a></td>
            <td><a href='/download.php?file=$name'>$size</a></td>
            <td sorttable_customkey='$timekey'><a href='/download.php?file=$name'>$modtime</a></td>
          </tr>");
		  
		  }
			
			
          
          
		  

			

		 
		}  // main For loop
		
		
      ?>
      </tbody>
    </table>
      
  </div>
  
</body>

</html>