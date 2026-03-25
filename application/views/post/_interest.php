<?php 
$now = strtotime(date('Y-m-d')); 
$start = strtotime($post->startdate);
$elpsed = $now - $start; 
switch ($post->interestperiod) {
	case 'Monthly':
	$months = round(($elpsed/(60 * 60 * 24 * 30.4)) + 1);
	$duedate = (date('Y-m-d', strtotime($post->startdate." +$months months")));
	break;
	case 'Annually':
	$months = round(($elpsed/(60 * 60 * 24 * 30.4 * 12)) + 1);
	$duedate = (date('Y-m-d', strtotime($post->startdate." +$months years")));
	break;
}
?>
<table id="principal_table" class="table table-striped table table-hover table-outline table-vcenter text-nowrap card-table datatable" role="grid" style="background:white;border-bottom: 1px solid #dedede;margin-bottom: -1px!important;">
	<thead>
		<tr role="row">
			<th class="text-center">OPENING BALANCE</th>
			<?php if($post->category_id == 1){ 
				echo "<th class='text-center'>DEPOSITS</th>"; 
			}else{ 
				echo "<th class='text-center'>REPAYMENTS</th>"; 
			} ?>
			<?php if($post->category_id == 1){ 
				echo "<th class='text-center'>WITHDRAWALS</th>"; 
			}else{ 
				echo "<th class='text-center'>TOP UPS</th>"; 
			} ?>
			<th class="text-center">CURRENT PRINCIPAL</th>
		</tr>
	</thead>
	<tbody>
		<tr style="background: white;">
			<td class="text-center break-word"><?php if(isset($comments[0])) echo html_escape($post->currency).' '.positive_number($comments[0]->amount) ?></td>
			<?php if($post->category_id == 1){ ?>
				<td class="text-center break-word" id="deposits"></td>
				<td class="text-center nowrap" id="withdrawals"></td>
			<?php }else{ ?>
				<td class="text-center nowrap" id="withdrawals"></td>
				<td class="text-center break-word" id="deposits"></td>
			<?php } ?>
			
			<td class="text-center" id="principal"></td>
		</tr>
	</tbody>
</table>

<table id="interest_table" class="table table-striped table table-hover table-outline table-vcenter text-nowrap card-table datatable <?php if($post->interestrate == '0'){ echo 'hide'; } ?>" role="grid" style="background:white;border-bottom: 1px solid #dedede;">
	<thead>
		<tr role="row">
			<th class="text-center">INTEREST RATE</th>
			<th class="text-center">TOTAL INTEREST</th>
			<!-- <th class='text-center interest-paid'>INTEREST PAID</th> -->
			<?php if($post->category_id == 1){ 
				echo "<th class='text-center'>CLOSING BALANCE</th>"; 
			}else{ 
				echo "<th class='text-center'>OUTSTANDING BALANCE</th>"; 
			} ?>
		</tr>
	</thead>
	<tbody>
		<tr style="background: white;">
			<td class="text-center nowrap"><?= $post->interestrate; ?>% <?= $post->interestperiod; ?></td>
			<td class="text-center break-word" id="interest"></td>
			<!-- <td class='text-center interest-paid'></td> -->
			<td class="text-center break-word" id="closing_balance"></td>
		</tr>
	</tbody>
</table>