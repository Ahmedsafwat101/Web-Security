<?php
	require_once 'login.php';

	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error) die("Opps!!");
	
	$query = "CREATE TABLE IF NOT EXISTS webinfo (
		id SMALLINT NOT NULL AUTO_INCREMENT,
		name VARCHAR(32) NOT NULL,
		content text NOT NULL,
		PRIMARY KEY (id)
	)";

	$result = $conn->query($query);
	if (!$result) die ("Opps");//modify
	
 echo <<<_END
<html><head><title>PHP Form Upload</title></head><body>
<form method='post' action='webpage.php' enctype='multipart/form-data'> 
<pre>
File_NAME<input type="text" name="firstval">
Select File: <input type='file' name='filename'>
<input type='submit' value='Add record'>
</pre>
</form>
_END;

function Uploading_file($conn){
if ($_FILES)
{
  $File_name=htmlentities($_FILES["filename"]["name"]);
  if(!(htmlentities($_FILES["filename"]["type"])=='text/plain')) 
  {
	echo"Sorry Please Enter Only txt files!<br>";  
    return 0; //first test
  }
  echo "<pre>";
  $text= file_get_contents($File_name);
  echo"$text";  
  echo "</pre>";
 if (isset($_POST['firstval'])&& !empty($_POST["firstval"]))
{
	$name = get_post($conn,'firstval');
	$query = "INSERT INTO webinfo VALUES" ."(NULL,'$name','$text')";
	$result = $conn->query($query);

	if (!$result) echo "INSERT failed: $query<br>";//modify
}

   return $text; 
}
echo "</body></html>";
}

$data=Uploading_file($conn);


//database
$query = "SELECT * FROM webinfo";
$result = $conn->query($query);
if (!$result) die ("Opps");
$rows = $result->num_rows;
for($j=0;$j<$rows;++$j)
{
	$result->data_seek($j);
	$row = $result->fetch_array(MYSQLI_NUM);
	echo <<<_END
	<pre>
	ID:$row[0]
	Name:$row[1]
	Content:$row[2]
	</pre>
_END;
}

$result->close();
$conn->close();	

function get_post($conn,$var)
{
	return $conn->real_escape_string($_POST[$var]);
} 




?>

