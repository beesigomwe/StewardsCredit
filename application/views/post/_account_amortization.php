<?php
	$amount = 0;
	if(isset($comments[0]) && isset($comments[0]->amount)) $amount = $comments[0]->amount;
	$rate = $post->interestrate;
	$years = 0.5; //TODO: Count the number of years the loan is due for

	if(isset($_GET['amount'])) $amount = $_GET['amount'];
	if(isset($_GET['rate'])) $rate = $_GET['rate'];
	if(isset($_GET['years'])) $years = $_GET['years'];

	$am = $this->amort_model->runamort($amount,$rate,$years);

	echo $this->amort_model->showForm($am);

	if($amount * $rate * $years <> 0){
		echo "</div></div><div class='card'><div class='card-body'>";
		echo $this->amort_model->showTable(true, $am);
	}
