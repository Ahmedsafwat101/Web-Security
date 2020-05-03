<?php

Function ConvertingToDecimal($x)
{
	$FinalValue = 0;

	//declare the Romans ("Hard_coded")
	// the order of chars are reversed to apply the combination of the high value first 
	$RomanCharacters = array(
	'M' => 1000,
    'CM' => 900,
    'D' => 500,
    'CD' => 400,
    'C' => 100,
    'XC' => 90,
    'L' => 50,
    'XL' => 40,
    'X' => 10,
    'IX' => 9,
    'V' => 5,
    'IV' => 4,
    'I' => 1,);

	foreach ($RomanCharacters as $key => $mapingvalue) {
    while (strpos($x, $key) === 0) {
        $FinalValue += $mapingvalue; //update with each substring
        $x = substr($x, strlen($key)); // split the string to sub string 
    }
}
echo $FinalValue."<br>";
return $FinalValue;	
}

Function Test()
{
	$InputinRomans = "fgadgt";
	
	//checking invalid input
	if(ConvertingToDecimal($InputinRomans)==0)
	  echo"Invalid input<br>";
  
    $InputinRomans = " ";
	
	//checking invalid input
	if(ConvertingToDecimal($InputinRomans)==0)
	  echo"Invalid input<br>";

    $InputinRomans = "VI";  
  
    if(ConvertingToDecimal($InputinRomans)==6)
	  echo"Passed the First Test<br>";
    else
    {
	  echo "First Test Filled !!!<br>";
	  return 0 ;
    }
	
	$InputinRomans = "IV";

    if(ConvertingToDecimal($InputinRomans)==4)
	  echo"Passed the Second Test<br>";
    else
    {
	  echo "Second Test Filled !!!<br>";
	  return 0 ;
    }
	
	$InputinRomans = "MCMXC";

    if(ConvertingToDecimal($InputinRomans)==1990)
	  echo"Passed the Third Test<br>";
    else
    {
	  echo "Third Test Filled !!!<br>";
	  return 0 ;
    }
	
	$InputinRomans = "IX";

    if(ConvertingToDecimal($InputinRomans)==9)
	  echo"Passed the Fourth Test<br>";
    else
    {
	  echo "Fourth Test Filled !!!<br>";
	  return 0 ;
    }


}


Test();



?>
