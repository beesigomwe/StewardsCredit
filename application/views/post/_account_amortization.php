<?php
	$amount = 0;
	if(isset($comments[0]) && isset($comments[0]->amount)) $amount = $comments[0]->amount;
	$rate = $post->interestrate;

	// FIX: Dynamically calculate the loan duration in years from the account's start and end dates.
	// Falls back to 1 year if dates are missing or invalid.
	$years = 1;
	if (!empty($post->startdate) && !empty($post->enddate)) {
		$start_ts = strtotime($post->startdate);
		$end_ts   = strtotime($post->enddate);
		if ($start_ts && $end_ts && $end_ts > $start_ts) {
			$days_diff = ($end_ts - $start_ts) / 86400;
			$years = round($days_diff / 365, 4);
		}
	}

	// Allow URL overrides for the amortization calculator form
	if(isset($_GET['amount'])) $amount = (float)$_GET['amount'];
	if(isset($_GET['rate']))   $rate   = (float)$_GET['rate'];
	if(isset($_GET['years']))  $years  = (float)$_GET['years'];

	$am = $this->amort_model->runamort($amount, $rate, $years);

	echo $this->amort_model->showForm($am);

	if($amount * $rate * $years <> 0){
		echo "</div></div><div class='card'><div class='card-body'>";
		echo $this->amort_model->showTable(true, $am);
	}
