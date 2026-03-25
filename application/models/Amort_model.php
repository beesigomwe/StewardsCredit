<?php
//
// class.amort.php
// version 1.0.1, 18 July, 2005
// version 1.0.1, 14 Feb, 2006
//   Fixed divide by zero problem when input values are zero.
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
//  Total amount paid over the life of the loan.
//  Total interest paid over the life of the loan.
//  Total number of monthly payments.
//  The monthly payment.
//

defined('BASEPATH') OR exit('No direct script access allowed');

class Amort_model extends CI_Model{
var $amount;   //amount of the loan
var $rate;    //percentage rate of the loan
var $years;    //number of years of the loan
var $npmts;    //number of payments of the loan
var $mrate;    //monthly interest rate
var $tpmnt;    //total amount paid on the loan
var $tint;     //total interest paid on the loan
var $pmnt;     //monthly payment of the loan

//amort is the constructor and sets up the variable values
//using the three values passed to it.

public function runamort($amount=0,$rate=0,$years=0){
	$data = (object) [];
$data->amount=$amount;  //amount of the loan
$data->rate=$rate;    //yearly interest rate in percent
$data->years=$years;   //length of loan in years
if($amount*$rate*$years > 0){
$data->npmts=$years*12; //number of payments (12 per year)
$data->mrate=$rate/1200; //monthly interest rate
$data->pmnt=$amount*($data->mrate/(1-pow(1+$data->mrate,-$data->npmts))); //monthly payment
$data->tpmnt=$data->pmnt * $data->npmts; //total amount paid at end of loan
$data->tint=$data->tpmnt-$amount;     //total amount of interest paid at end of loan
}else{
	$data->pmnt=0;
	$data->npmts=0;
	$data->mrate=0;
	$data->tpmnt=0;
	$data->tint=0;
}
return $data;
}
//returns the monthly payment in dolars (two decimal places)
public function payment($data){
	return sprintf("%01.2f",$data->pmnt);
}

//returns the total amount paid at the end of the loan in dolars
public function totpayment($data){
	return sprintf("%01.2f",$data->tpmnt);
}

//returns the total interest paid at the end of the loan in dolars
public function totinterest($data){
	return sprintf("%01.2f",$data->tint);
}

//displays the form to enter amount, rate and length of loan in years
public function showForm($data){
	$table = "";
	$table .= "<h3 align='center'>Amortization Schedule</h3>";
	$table .= "<p align='center'> </p>";
	$table .= "<form action='' method='GET' name='amort'>";
	$table .= "<div class='table-responsive'><table width='100%' class='table table-hover table-outline table-vcenter text-nowrap card-table'>";
	$table .= "<tr><td width='33%' align='center' height='35'>";
	$table .= "<dl><dt>Amount of Loan</dt><dt class='hidden-print'>(no commas)</dt>";
	$table .= "<dt><input class='form-control' type='text' name='amount' value='$data->amount' align='top' maxlength='10' size='20'>";
	$table .= "</dt></dl></td>";
	$table .= "<td width='33%' height='35' align='center'>";
	$table .= "<dl><dt>Annual Interest Rate</dt><dt class='hidden-print'>(in percent)</dt>";
	$table .= "<dt><input class='form-control' type='text' name='rate' value='$data->rate' align='top' maxlength='5' size='20'>";
	$table .= "</dt></dl></td>";
	$table .= "<td width='34%' height='35' align='center'>";
	$table .= "<dl><dt>Length of Loan</dt><dt class='hidden-print'>(in years)</dt>";
	$table .= "<dt><input class='form-control' type='text' name='years' value='$data->years' align='top' maxlength='4' size='20'>";
	$table .= "</dt></dl></td></tr></table></div>";
	$table .= "<p class='text-center hidden-print'><input class='btn btn-primary' type='submit' value='Submit' align='middle'></form>";
	return $table;
}

//if $show is false:
//   displays:
//        monthly payment
//        number of payments in the loan
//        total paid at end of loan
//        total interest paid at end of loan
//if $show is true:
//  displays: everything for false case plus the amortization table

public function showTable($show, $data){
	$table = "";
	$table .= "<div class='table-responsive'><table width='100%'>";
	$table .= "<td width='25%' align='center'><dt>Total Payments</dt>";
	$table .= "<dt>";
	$table .= sprintf("%01.2f",$data->tpmnt);
	$table .= "</dt></td>";
	$table .= "<td width='25%' align='center'><dt>Total Interest</dt>";
	$table .= "<dt>";
	$table .= sprintf("%01.2f",$data->tint);
	$table .= "</dt></td>";
//$table .= "</tr></table>";
//$table .= "<table border='1' width='100%'>";
// $table .= "<tr>";
//  $table .= "<td width='33%' align='center'><dt>Monthly Interest Rate</dt>";
//   $table .= "<dt>";
//    $table .= sprintf("%01.2f",$data->mrate*100);
//     $table .= "</dt></td>";

	$table .= "<td width='25%' align='center'><dt>Number of Monthly Payments</dt>";
	$table .= "<dt>";
	$table .= $data->npmts;
	$table .= "</dt></td>";

	$table .= "<td width='25%' align='center'><dt>Monthly Payment</dt>";
	$table .= "<dt>";
	$table .= sprintf("%01.2f",$data->pmnt);
	$table .= "</dt>";
	$table .= "</td></tr>";
	if($show){
		$table .= "</table><br></div>";
		$table .= "<div class='table-responsive'><table width='100%' class='table table-hover table-outline table-vcenter text-nowrap card-table'><tr>";
		$table .= "<td align='center'>No.</td>";
		$table .= "<td align='center'>Beginning<br>Balance</td>";
		$table .= "<td align='center'>Interest<br>Payment</td>";
		$table .= "<td align='center'>Principal<br>Payment</td>";
		$table .= "<td align='center'>Ending<br>Balance</td>";
		$table .= "<td align='center'>Cumulative<br>Interest</td>";
		$table .= "<td align='center'>Cumulative<br>Payments</td>";
		$table .= "</tr>";

		$ebal = $data->amount;
		$ccint =0.0;
		$cpmnt = 0.0;

		for ($pnum = 1; $pnum <= $data->npmts; $pnum++){
			$table .= "<tr>";
			$table .= "<td align='center'>$pnum</td>";
			$bbal = $ebal;
			$table .= "<td align='right'>". positive_number(sprintf("%01.2f",$bbal)) . "</td>";
			$ipmnt = $bbal * $data->mrate;
			$table .= "<td align='right'>" . positive_number(sprintf("%01.2f",$ipmnt)) . "</td>";
			$ppmnt = $data->pmnt - $ipmnt;
			$table .= "<td align='right'>" . positive_number(sprintf("%01.2f",$ppmnt)) . "</td>";
			$ebal = $bbal - $ppmnt;
			$table .= "<td align='right'>" . positive_number(sprintf("%01.2f",$ebal)) . "</td>";
			$ccint = $ccint + $ipmnt;
			$table .= "<td align='right'>" . positive_number(sprintf("%01.2f",$ccint)) . "</td>";
			$cpmnt = $cpmnt + $data->pmnt;
			$table .= "<td align='right'>" . positive_number(sprintf("%01.2f",$cpmnt)) . "</td>";
			$table .= "</tr>";
		}
		$table .= "</table></div>";
	}
	return $table;
}
}