<?php //Userpage.php
require_once 'login2.php';

	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error) die("Opps!!");
	

function Uploading_file(){
if ($_FILES)
{
  $File_name=htmlentities($_FILES["filename"]["name"]);
  //$File_size=htmlentities($_FILES["filename"]["size"]);

  
if(!(htmlentities($_FILES["filename"]["type"])=='text/plain')) // first test 
  {
    //return 1; //first test
	echo"Something wrong happend plz submit the file again :)";
	return "Exit";
  }
  
  echo "<pre>";
  $handle = fopen($File_name, "r");
  $contents = fread($handle, 20); // update
  fclose($handle);
  //$text= file_get_contents($File_name);
  echo "</pre>";
  return $contents;

}
}

echo <<<_END
        <html><head><title>PHP Form Upload</title></head><body>
		<form method='post' action='Userpage.php' enctype='multipart/form-data'> 
        Select File: <input type='file' name='filename' id="filename">
        <input type='submit' name="mybut" id="AddFile" value="AddFile">
        </form>
_END;
echo "</body></html>";
if (isset($_POST['mybut'])=="AddFile")
{
  $var=Uploading_file();
  if($var!="Exit")
  {
	matchingdata($var,$conn);
  }	
}

$conn->close();	


function matchingdata($content,$conn){
	
	$query = "SELECT * FROM Antivirus" ;
	$result = $conn->query($query);
	if (!$result) die("Error");
	$rows = $result->num_rows;
	$result->close();
    if ($rows==0) die("Clean file");
	else
	{
       $i=0;		
       for($j=0;$j<$rows;++$j)
       {
	    $result->data_seek($j);
	    $row = $result->fetch_array(MYSQLI_NUM);
		if(stristr($content,$row[2])===false)
		{
			$i++;
			echo " Malware with name $row[1] not matched .</br>";
		}
		else{
			echo"the name of malware is $row[1] (matched).</br>";
			break;
		}
       }
	   	echo"End.</br>";

	}
}

?>