<div id="depositForm" class="row transactionForm" role="" style="display: none;">
	<div class="col-lg-6 mx-auto">
		<?php switch ($post->category_id) {
			case '1':
			include '_make_deposit.php';
			break;
			case '2':
			include '_make_loanrepayment.php';
			break;
		} ?>
	</div>
</div>