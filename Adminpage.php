<?php
require_once 'login2.php';

	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error) die("Opps!!");
	
    //create table in database publications for savingn the data 
 	$query = "CREATE TABLE IF NOT EXISTS Antivirus (
		id SMALLINT NOT NULL AUTO_INCREMENT,
		virusname VARCHAR(32) NOT NULL,
	    header CHAR(20) NOT NULL,
		PRIMARY KEY (id)
	)";
	$result = $conn->query($query);
	if (!$result) die ("Opps!!");
	
	
	//create  table for Admin info 
	$query2 = "CREATE TABLE IF NOT EXISTS Admininfo (
	   ID SMALLINT NOT NULL AUTO_INCREMENT,
       name VARCHAR(32) NOT NULL,
	   password CHAR(32) NOT NULL,
	   salt VARCHAR(5) Not NULL,
	   PRIMARY KEY (id)
	)";
	$result2 = $conn->query($query2);
	if (!$result2) die ("Opps3");
	
	
if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
	{
	    $un_temp = mysql_entities_fix_string($conn, $_SERVER['PHP_AUTH_USER']);
	    $pw_temp = mysql_entities_fix_string($conn, $_SERVER['PHP_AUTH_PW']);
	    $query = "SELECT * FROM Admininfo WHERE name='$un_temp'";
	    $result = $conn->query($query);
        if (!$result) die("Error");
		if ($result->num_rows) 
		{
			$row = $result->fetch_array(MYSQLI_NUM);
			$result->close();
			$randSalt=$row[3];// hard coded in Sql if I want to generate it use random_bytes(5)
			$token = hash('ripemd128', "$randSalt$pw_temp");
			//echo $token;
			if ($token == $row[2]) 
				echo " Hi $row[1], you are now logged in ";
			else die("Invalid username/password combination1");
		}
		else die("Invalid username/password combination2");
	}
	
else  
	{ 
	// if ($_SERVER['PHP_AUTH_USER’])  and  ($_SERVER['PHP_AUTH_PW’]) are not set
		header('WWW-Authenticate: Basic realm="Restricted Section"');
		header('HTTP/1.0 401 Unauthorized');
		die ("Please enter your username and password");
		$result->close();
        $result2->close();
        $conn->close();	
	}
	

	 echo <<<_END
<html><head><title>PHP Form Upload</title></head><body>
<form method='post' action='Adminpage.php' enctype='multipart/form-data'> 
<pre>
VirusName: <input type='text' name="VN">
Select File: <input type='file' name='filename'>
<input type='submit' name="mybut2" id="AddFile" value="AddFile">
</pre>
</form>
_END;
	
if (isset($_POST['mybut2'])=="AddFile" ) #Add button was clicked
{
	if(isset($_POST['VN']))
	{
			$header=Uploadingfile($conn);
			
			if ($header==="Exit")
			{
			  echo"Submit the file again plz";	
			}
			else{
            $virusname=mysql_fix_string($conn,get_post($conn,'VN'));
			$query = $conn->prepare('INSERT INTO Antivirus VALUES(NULL,?,?)');
	        $query->bind_param('ss',$virusname, $header);
	        $query->execute();
	        $query->close();
			echo"Done.<\br>";
			}
	}	
}


function get_post($conn,$var)
{
	return $conn->real_escape_string($_POST[$var]);
} 


function FatchingData($name,$conn)
{
   $var= mysql_fix_string($conn,$name);
   //echo"$filtedrvar";
   $query = "SELECT * FROM Admininfo where name='$var'";
   $res = $conn->query($query);
   $rows = $res->num_rows;
   if ($rows==0) die("There is no Advisor with name $var");
   //$rows = $result->num_rows;
   //if ($rows==0 ) die("There is no Admin with name $var");  
   else
   {
	   echo"Done";
   }	   
}
function Uploadingfile($conn){
  if ($_FILES){	  
  $File_name=htmlentities($_FILES["filename"]["name"]);
  if(!(htmlentities($_FILES["filename"]["type"])=='text/plain')) 
  {
	echo"Sorry Please Enter Only txt files!<br>";  
    return "Exit"; //first test
  }
  echo "<pre>";
  $fp = fopen($File_name,'r');
  $text = fread($fp,20);  
  fclose($fp);
  //echo"$text";  
  return $text; 
  }
echo "</body></html>";
}
	
function mysql_entities_fix_string($connection, $string) 
{
    return htmlentities(mysql_fix_string($connection, $string));
}
	
function mysql_fix_string($connection, $string) 
{
	if (get_magic_quotes_gpc()) 
		$string = stripslashes($string);
	return $connection->real_escape_string($string);
}

	
	
?>