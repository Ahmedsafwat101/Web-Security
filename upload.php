<?php // upload.php
function Uploading_file(){
   echo <<<_END
        <html><head><title>PHP Form Upload</title></head><body>
		<form method='post' action='upload.php' enctype='multipart/form-data'> 
        Select File: <input type='file' name='filename' size='1000'>
		<input type='submit' value='Upload'>
        </form>
_END;
$copyvalue="";
if ($_FILES)
{
  $File_name=htmlentities($_FILES["filename"]["name"]);
  $File_size=htmlentities($_FILES["filename"]["size"]);

  
  if(!(htmlentities($_FILES["filename"]["type"])=='text/plain')) // first test 
  {
    return 1; //first test
  }
  
  if(htmlentities($_FILES["filename"]["size"])>1000) // second test 
  {
    echo"Your file passed the limit!!<br>";
	return 2; //first test
  }
  
      
  echo "<pre>";
  $text= file_get_contents($File_name); // I’ve requested three characters in the fread call
  echo "</pre>";
  //echo strlen($text);
  
  
  if (!(ctype_digit($text))) 
  {
    return 3;
  }
  
  echo $text."<br>";
  LargestMultiply($text,$File_size);
  
}
echo "</body></html>";
}

function LargestMultiply($Data,$File_size)
{
	$Mul=1;
	$Max=-999999999999999;
	$Myindex=0;
	for($i=0;$i<$File_size;$i++)
	{
		if($File_size-$i<5)
		{
			break;
		}
		$Mul=$Data[$i];
		for($j=($i+1);$j<($i+5);$j++)
		{
		  $Mul=$Mul*$Data[$j];
		}
		//echo"$Mul<br>";
		//echo"$i<br>";
		//getteing the value
		if($Max<$Mul)
		{
			$Max=$Mul;
			$Myindex=$i;
		}
	}
	echo"The Max Value is:<br>";
	echo"$Max<br>";
	echo"The numbers are:<br>";
	for($i=$Myindex;$i<$Myindex+5;$i++)
	{
		echo"$Data[$i]<br>"; 
	}
	Factorial($Max);
	
}

function Factorial($value)
{
	$finalSum=0;
	$lengthoftheinput=log10($value);
	//echo"$lengthoftheinput";
	$value=strval($value);
	for($i=0;$i<$lengthoftheinput;$i++)
	{
		//echo"ajj<br>";
		$FactorialSum=1;
		//echo"$value[$i]<br>";
		if($value[$i]==0)
		{
           $FactorialSum=0;	  	
		}
		echo"Factorial $value[$i]<br>";
		for($j=1;$j<=$value[$i];$j++)
		{
			$FactorialSum=$FactorialSum*$j;
		}
	    echo"$FactorialSum<br>";
		$finalSum=$finalSum+$FactorialSum;
	    //echo"$finalSum<br>";

	}
	echo"Total sum of factorial:<br>";
	echo"$finalSum<br>";
	
}


function Main()
{
	Test();
}
Function Test()
{
	$value=Uploading_file();
	if($value==1)
	{
	    echo"Your file format is not acceptable Please upload only .txt files<br>";

	}
	else if($value==2)
	{
		echo"Your file passed the limit more than 1000!!!<br>";
	}
	else if($value===3)
	{
	    echo "Contains non-numbers<br>";
	}
	
}

Main();//Run
?>