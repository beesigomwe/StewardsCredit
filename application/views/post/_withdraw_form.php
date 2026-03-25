<div id="withdrawForm" class="row transactionForm" role="" style="display: none;">
	<div class="col-lg-6 mx-auto">
		<?php switch ($post->category_id) {
			case '1':
			include '_make_withdraw.php';
			break;
			case '2':
			include '_make_loantopup.php';
			break;
		} ?>
	</div>
</div>