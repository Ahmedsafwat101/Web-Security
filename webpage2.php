<?php
require_once 'login2.php';

	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error) die("Opps!!");
	
      //create table in database publications
 	$query = "CREATE TABLE IF NOT EXISTS schoolinfo (
		id SMALLINT NOT NULL AUTO_INCREMENT,
		advisorname VARCHAR(32) NOT NULL,
		studentname VARCHAR(32) NOT NULL,
		studentid SMALLINT NOT NULL,
		classcode VARCHAR(32) NOT NULL,
		PRIMARY KEY (id)
	)";
	
	$result = $conn->query($query);
	if (!$result) die ("Opps");
	
	//Add Section 	
echo<<<_END
<html><head><title>Add Section</title></head><body>
<form method='post' action='webpage2.php' enctype='multipart/form-data'> 
<pre>
Advisor Name <input type="text" name="AN">
Student Name <input type="text" name="SN">
Student ID <input type="text" name="SID">
Class Code <input type="text" name="CC">
<input type='submit' name="mybut" id="add" value="add">
<br>
<input type="text" name="serachbox">
<input type='submit' name="mybut2" id="search" value="search">
</pre>
</form>
_END;
	
 

if (isset($_POST['mybut'])=="add") #Add button was clicked
{
	echo"add";
    if (isset($_POST['AN'])&& isset($_POST['SN'])&&isset($_POST['SID'])&&isset($_POST['CC']))
    { 
	 $advisorname =  mysql_fix_string($conn,get_post($conn,'AN'));
	 $studentname =  mysql_fix_string($conn,get_post($conn,'SN'));
	 $studentid =  mysql_fix_string($conn,get_post($conn,'SID'));
	 $classcode =  mysql_fix_string($conn,get_post($conn,'CC'));
	 $query = $conn->prepare('INSERT INTO schoolinfo VALUES(NULL,?,?,?,?)');
	 $query->bind_param('ssss',$advisorname, $studentname, $studentid, $classcode);
	 $query->execute();
	 $query->close();
    }
}

elseif (isset($_POST['mybut2'])=="search") #search button was clicked
{
  if(isset($_POST['serachbox']))
  {
	$varname=$_POST['serachbox'];  
	  FatchingData($varname,$conn);
  }
}

function get_post($conn,$var)
{
	return $conn->real_escape_string($_POST[$var]);
} 

function mysql_fix_string($conn, $string) 
{
	if (get_magic_quotes_gpc()) 
		$string = stripslashes($string);
	return $conn->real_escape_string($string);
}

function FatchingData($advisor,$conn)
{
   $filtedrvar= mysql_fix_string($conn,$advisor);
   //echo"$filtedrvar";
   $query = "SELECT * FROM schoolinfo where advisorname='$filtedrvar'";
   $result = $conn->query($query);
   if (!$result) die ("Opps");
   $rows = $result->num_rows;
   if ($rows==0) die("There is no Advisor with name $filtedrvar");
   for($j=0;$j<$rows;++$j)
   {
	$result->data_seek($j);
	$row = $result->fetch_array(MYSQLI_NUM);
	echo <<<_END
	<pre>
	 Advisor Name:$row[1]
	 Student Name:$row[2]
	 Student_ID :$row[3]
     Class_Code :$row[4]
	</pre>
_END;
   }
}	

	
?>