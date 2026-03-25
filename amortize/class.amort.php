<?php
//
// class.amort.php
// version 1.0.1, 18 July, 2005
// version 1.0.1, 14 Feb, 2006
//     Fixed divide by zero problem when input values are zero.
//
// License
//
// PHP class to calculate and display an amorization schedule table given
// the amount of loan, the interest rate, and the length of the loan.
//
// Copyright (C) 2005 George A. Clarke, webmaster@gaclarke.com, http://gaclarke.com/
//
// This program is free software; you can redistribute it and/or modify it under
// the terms of the GNU General Public License as published by the Free Software
// Foundation; either version 2 of the License, or (at your option) any later
// version.
//
// This program is distributed in the hope that it will be useful, but WITHOUT
// ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
// FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License along with
// this program; if not, write to the Free Software Foundation, Inc., 59 Temple
// Place - Suite 330, Boston, MA 02111-1307, USA.
//
// Description
//
// This class will calculate and display an amortization schedule given the
// amount of the loan, the interest rate of the loan, and the length in years
// of the loan.
//
// Optionally, it will either display the entire schedule
// or just the following calculated amounts:
//    Total amount paid over the life of the loan.
//    Total interest paid over the life of the loan.
//    Total number of monthly payments.
//    The monthly payment.
//

class amort{
 var $amount;      //amount of the loan
 var $rate;        //percentage rate of the loan
 var $years;        //number of years of the loan
 var $npmts;        //number of payments of the loan
 var $mrate;        //monthly interest rate
 var $tpmnt;        //total amount paid on the loan
 var $tint;         //total interest paid on the loan
 var $pmnt;         //monthly payment of the loan

//amort is the constructor and sets up the variable values
//using the three values passed to it.

function amort($amount=0,$rate=0,$years=0){
 $this->amount=$amount;   //amount of the loan
 $this->rate=$rate;       //yearly interest rate in percent
 $this->years=$years;     //length of loan in years
if($amount*$rate*$years > 0){
 $this->npmts=$years*12;  //number of payments (12 per year)
 $this->mrate=$rate/1200; //monthly interest rate
 $this->pmnt=$amount*($this->mrate/(1-pow(1+$this->mrate,-$this->npmts))); //monthly payment
 $this->tpmnt=$this->pmnt * $this->npmts;  //total amount paid at end of loan
 $this->tint=$this->tpmnt-$amount;         //total amount of interest paid at end of loan
}else{
 $this->pmnt=0;
 $this->npmts=0;
 $this->mrate=0;
 $this->tpmnt=0;
 $this->tint=0;
}
}
//returns the monthly payment in dolars (two decimal places)
function payment(){
return sprintf("%01.2f",$this->pmnt);
}

//returns the total amount paid at the end of the loan in dolars
function totpayment(){
return sprintf("%01.2f",$this->tpmnt);
}

//returns the total interest paid at the end of the loan in dolars
function totinterest(){
return sprintf("%01.2f",$this->tint);
}

//displays the form to enter amount, rate and length of loan in years
function showForm(){
print "<h1 align='center'>Amortization Schedule</h1>";
print "<p align='center'> </p>";
print "<form action='$PHP_SELF' method='GET' name='amort'>";
print "<table border='1' width='100%' height='40'>";
print "<tr><td width='33%' align='center' height='35'>";
print "<dl><dt>Amount of Loan</dt><dt>(in dollars, no commas)</dt>";
print "<dt><input type='text' name='amount' value='$this->amount' align='top' maxlength='6' size='20'>";
print "</dt></dl></td>";
print "<td width='33%' height='35' align='center'>";
print "<dl><dt>Annual Interest Rate</dt><dt>(in percent)</dt>";
print "<dt><input type='text' name='rate' value='$this->rate' align='top' maxlength='5' size='20'>";
print "</dt></dl></td>";
print "<td width='34%' height='35' align='center'>";
print "<dl><dt>Length of Loan</dt><dt>(in years)</dt>";
print "<dt><input type='text' name='years' value='$this->years' align='top' maxlength='2' size='20'>";
print "</dt></dl></td></tr></table>";
print "<p><input type='submit' value='Click to submit.' align='middle'></form>";
}

//if $show is false:
//     displays:
//               monthly payment
//               number of payments in the loan
//               total paid at end of loan
//               total interest paid at end of loan
//if $show is true:
//    displays: everything for false case plus the amortization table

function showTable($show){
print "<table border='1' width='100%'>";
    print "<td width='25%' align='center'><dt>Total Payments</dt>";
      print "<dt>";
       print sprintf("$%01.2f",$this->tpmnt);
         print "</dt></td>";
    print "<td width='25%' align='center'><dt>Total Interest</dt>";
      print "<dt>";
       print sprintf("$%01.2f",$this->tint);
         print "</dt></td>";
//print "</tr></table>";
//print "<table border='1' width='100%'>";
//  print "<tr>";
//    print "<td width='33%' align='center'><dt>Monthly Interest Rate</dt>";
//      print "<dt>";
//       print sprintf("$%01.2f",$this->mrate*100);
//         print "</dt></td>";

    print "<td width='25%' align='center'><dt>Number of Monthly Payments</dt>";
      print "<dt>";
       print $this->npmts;
         print "</dt></td>";

    print "<td width='25%' align='center'><dt>Monthly Payment</dt>";
      print "<dt>";
      print sprintf("$%01.2f",$this->pmnt);
         print "</dt>";
  print "</td></tr>";
if($show){
  print "</table>";
  print "<table border='1' width='100%'><tr>";
  print "<td width='14%' align='center'>Payment Number</td>";
  print "<td width='14%' align='center'>Beginning Balance</td>";
  print "<td width='14%' align='center'>Interest Payment</td>";
  print "<td width='14%' align='center'>Principal Payment</td>";
  print "<td width='14%' align='center'>Ending Balance</td>";
  print "<td width='14%' align='center'>Cumulative Interest</td>";
  print "<td width='14%' align='center'>Cumulative Payments</td>";
 print "</tr>";

$ebal = $this->amount;
$ccint =0.0;
$cpmnt = 0.0;

for ($pnum = 1; $pnum <= $this->npmts; $pnum++){
  print "<tr>";
  print "<td width='14%' align='center'>$pnum</td>";
  $bbal = $ebal;
  print "<td width='14%' align='right'>$". sprintf("%01.2f",$bbal) . "</td>";
  $ipmnt = $bbal * $this->mrate;
  print "<td width='14%' align='right'>$" . sprintf("%01.2f",$ipmnt) . "</td>";
  $ppmnt = $this->pmnt - $ipmnt;
  print "<td width='14%' align='right'>$" . sprintf("%01.2f",$ppmnt) . "</td>";
  $ebal = $bbal - $ppmnt;
  print "<td width='14%' align='right'>$" . sprintf("%01.2f",$ebal) . "</td>";
  $ccint = $ccint + $ipmnt;
  print "<td width='14%' align='right'>$" . sprintf("%01.2f",$ccint) . "</td>";
  $cpmnt = $cpmnt + $this->pmnt;
  print "<td width='14%' align='right'>$" . sprintf("%01.2f",$cpmnt) . "</td>";
  print "</tr>";
 }
 print "</table>";
 }
}
}
//End of amort class
?>  


