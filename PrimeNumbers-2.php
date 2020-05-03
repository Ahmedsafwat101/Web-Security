<?php

//check Prime number
Function IsPrime($val)
{
	for ($j=2;$j<$val;$j++){if($val%$j==0){return false;}}
	return true;	
	
}
//saving values in array 
$array[]=array(); 

Function PrintPrimes($n)
{   
 
    if($n<=0)
	{
		echo"Invalid input <br>";
        return  ;	
	}
	
    
	
	
    $counter=0;  
	for ($i=2;$i<=$n;$i++)
	{
		if(IsPrime($i))
		{
			echo"$i<br>";
			$array[$counter] = $i;
			$counter++;
		}	
	}
    return $array;
}
//Testing Implementation
Function Test()
{
	
    $result=PrintPrimes(10);
    if($result[0]==2 and $result[1]==3 and $result[2]==5 and $result[3]==7 ){echo "First Test (10) Passed <br>";}
	
	$result=PrintPrimes(100);
    if($result[0]==2 and $result[1]==3 and $result[2]==5 and $result[3]==7 
   	and $result[4]==11 and $result[5]==13 and $result[6]==17 
	and $result[7]==19 and $result[8]==23
    and $result[9]==29 and $result[10]==31
    and $result[11]==37 and $result[12]==41
	and $result[13]==43 and $result[14]==47
    and $result[15]==53 and $result[16]==59
    and $result[17]==61 and $result[18]==67
	and $result[19]==71 and $result[20]==73
	and $result[21]==79 and $result[22]==83
	and $result[23]==89 and $result[24]==97) {echo "Second Test(100) Passed <br>";}	
	//invalid input tests
    $result=PrintPrimes(" ");
	echo ("Third Test( ) Passed <br>");
	//invalid input tests
	$result=PrintPrimes("a");
	echo "Fourth Test(a) Passed <br>";
    //invalid input tests
	$result=PrintPrimes(0);	
	echo "Fifth Test(0) Passed <br>";

}
    //Testing calls//
 Test();

?>