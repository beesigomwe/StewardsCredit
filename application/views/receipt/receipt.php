<?php 

// print_r($details);

?>

<style> .transactionForm {position: absolute; z-index: 1000; width: 100%; left: 0; right: 0; background: #ddeeffb8; height: 100vh; padding-top: 20px; padding-left: 20px; } .print-only {display: none; } @media print {.print-only {display: block; } .hidden-print {display: none!important; opacity: 0!important; max-height: 0; max-width: 0;} .card-header {display: block!important; margin-bottom: 5px; } .print-wide {min-width: 100%!important; } table, tr, th, tbody, td {border: 1px solid black!important; } table {border-bottom: 1px solid black!important; } h4, h4 *, .table th, .text-wrap table th {background: white!important; color: black!important; font-weight: bold!important; } div {background: white!important;color: black!important;} } .card-header nav .nav a.nav-item {padding: 8px 25px; border-bottom: none!important; text-shadow: none; color: #0172d2; margin-right: 10px; } .card-header-tabs {line-height: inherit!important; } .card-header div#nav-tab {margin: 0!important; } .color-red, .color-red * {color: #b40404!important; } .dropdown-menu.show {display: block; box-shadow: 1px 2px 9px -5px black; } </style>

<!-- Section: main -->
<section id="main">
	<div class="container">
		<div class="row">
			<div class="col-12 print-only">
				<h1 class="text-center">Stewards Credit Services</h1>
				<!-- <p class="text-center">P.O. Box Kampala. &bull; Phone: +256700000000</p> -->
			</div>
			<div class="col-12 print-wide">
				<div class="content">
					<div class="row">
						<!-- include message block -->
						<div class="col-sm-12">
							<?php $this->load->view('admin/includes/_messages'); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-12 card">
							<div class="card-header d-print-none hidden-print">
								<h3 class="card-title hidden-print">Transaction Details</h3>
								<div class="card-options hidden-print">
									<button type="button" class="btn btn-primary" onclick="javascript:window.print();"><i class="fe fe-printer"></i>&nbsp;&nbsp; Print </button>
								</div>
							</div>
							<div class="card-body">
								<div class="row hidden-print">
									<div class="col-6">
										<p class="h3">Stewards Credit Services</p>
										<!-- <address>
											Street Address<br>
											State, City<br>
											Region, Postal Code<br>
											ltd@example.com
										</address> -->
									</div>
									<div class="col-6 text-right">
										<p class="h3 hidden-print">DEPOSIT ADVICE</p>
										<!-- <address>
											Street Address<br>
											State, City<br>
											Region, Postal Code<br>
											ctr@example.com
										</address> -->
									</div>
									<!-- <div class="col-12 my-5">
										<h1>DEPOSIT ADVICE</h1>
									</div> -->
								</div>
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th style="width: 40%">Transaction Details</th>
												<th class="text-left" style="width: 60%"></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td> <p class="strong mb-1">Account Number</p> </td>
												<td class="text-left"><?php if($post->category_id == 1){ echo 1010000 + $post->id; }else{ echo 2010000 + $post->id; } ?></td>
											</tr>
											<tr>
												<td> <p class="strong mb-1">Customer Name</p> </td>
												<td class="text-left"><?= $post->fullname ?></td>
											</tr>
											
											<tr>
												<td> <p class="strong mb-1">Transaction Date</p> </td>
												<td class="text-left"><?= helper_date_format($details->trans_date) ?></td>
											</tr>
											<tr>
												<td> <p class="strong mb-1">Amount</p> </td>
												<td class="text-left"><?= $details->currency ?> <?= positive_number($details->amount) ?> (<?= $details->currency ?> <?= number_words($details->amount) ?>)</td>
											</tr>
											<tr>
												<td> <p class="strong mb-1">Narrative</p> </td>
												<td class="text-left"><?= $details->comment ?></td>
											</tr>
											
											<tr>
												<td> <p class="strong mb-1">Transaction Reference</p> </td>
												<td class="text-left"><?= $details->id ?></td>
											</tr>

											<?php /* foreach ($details as $key => $value) { ?>
												<tr>
													<td> <p class="strong mb-1"><?= $key ?></p> </td>
													<td class="text-left"><?php echo '< ? = '.$key.' ? >' ?></td>
												</tr>
											<?php } */ ?>

											<?php /*
											<!-- <tr>
												<td> <p class="strong mb-1">Payment Method</p> </td>
												<td class="text-left"><?= $details->payment_method ?></td>
											</tr> -->
											<!-- <tr>
												<td> <p class="strong mb-1">Transaction Type</p> </td>
												<td class="text-left"><?= $details->trans_type ?></td>
											</tr> -->
											<!-- <tr>
												<td> <p class="strong mb-1">Category</p> </td>
												<td class="text-left"><?= $details->category ?></td>
											</tr> -->

											<!-- <tr>
												<td class="strong text-right">Subtotal</td>
												<td class="text-right">$25.000,00</td>
											</tr> -->
											<!-- <tr>
												<td class="strong text-right">Vat Rate</td>
												<td class="text-right">20%</td>
											</tr> -->
											<!-- <tr>
												<td class="strong text-right">Vat</td>
												<td class="text-right"></td>
											</tr> -->
											<!-- <tr>
												<td class="font-weight-bold text-uppercase text-right">Total</td>
												<td class="font-weight-bold text-right">$30.000,00</td>
											</tr> --> */ ?>
										</tbody>
									</table>
								</div>
								<p class="text-muted text-center"><?= $details->uuid ?><br>Thank you very much for doing business with us. We look forward to working with
								you again!</p>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
