<?php
// This is an example of how to use class.amort.php class.

include "class.amort.php";

if (!$amount=$_GET['amount']){        //first time set all to zero
 $amount=0;
}
if (!$rate=$_GET['rate']){
 $rate=0;
}
if (!$years=$_GET['years']){
 $years=0;
}
$am=new amort($amount,$rate,$years);   //make an instance of amort and set the numbers
$am->showForm();                       //show the form to get the numbers
if($amount*$rate*$years <>0){          //if any one is zero, don't show the table
$am->showTable(true);                  //if true, show table, else don't
}
?>  
