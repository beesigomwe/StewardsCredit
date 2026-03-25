<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php 
$post->owner = get_user($post->userid);
$post->interestrate = str_replace("%", "", trim($post->interestrate));
$startdate = $post->startdate;
$interest_drawn = 0;
?>
<style> .transactionForm {position: absolute; z-index: 1000; width: 100%; left: 0; right: 0; background: #ddeeffb8; height: 100vh; padding-top: 20px; padding-left: 20px; } .print-only {display: none; } @media print {.print-only {display: block; } .hidden-print {display: none!important; } .card-header {display: block!important; margin-bottom: 5px; } .print-wide {min-width: 100%!important; } table, tr, th, tbody, td {border: 1px solid black!important; } table {border-bottom: 1px solid black!important; } h4, h4 *, .table th, .text-wrap table th {background: white!important; color: black!important; font-weight: bold!important; } div {background: white!important;color: black!important;} } .card-header nav .nav a.nav-item {padding: 8px 25px; border-bottom: none!important; text-shadow: none; color: #0172d2; margin-right: 10px; } .card-header-tabs {line-height: inherit!important; } .card-header div#nav-tab {margin: 0!important; } .color-red, .color-red * {color: #b40404!important; } .dropdown-menu.show {display: block; box-shadow: 1px 2px 9px -5px black; } .action {margin-bottom: 7px; } </style>

<?php if (auth_check() && is_admin()){
	include('_deposit_form.php');
	include('_withdraw_form.php');
} ?>
<script type="text/javascript">
	var currency = '', interest = 0, principal = 0, accountbalance = 0;
</script>
<!-- Section: main -->
<section id="main">
	<div class="container">
		<div class="row">
			<div class="col-12 print-only">
				<h1 class="text-center">Stewards Credit Services</h1>
				<!-- <p class="text-center">P.O. Box Kampala. &bull; Phone: +256700000000</p> -->
			</div>
			<div class="col-lg-9 print-wide">
				<div class="content">
					<div class="row">
						<!-- include message block -->
						<div class="col-sm-12">
							<?php $this->load->view('admin/includes/_messages'); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header p-0 hidden-print" style="min-height: 0px; ">
									<nav class="hidden-print"> 
										<div class="nav nav-tabs hidden-print" id="nav-tab" role="tablist">
											<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fe fe-file-text"></i>&nbsp;<?php $category_array = get_category_array($post->category_id); // echo html_escape($category_array['parent_category']->name); ?> Account Statement</a>
											<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fe fe-paperclip"></i>&nbsp;Attachments</a>
											<a class="nav-item nav-link text-left" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"><i class="fe fe-user"></i>&nbsp;Client Details</a>
											<a class="nav-item nav-link text-left" id="nav-alerts-tab" data-toggle="tab" href="#nav-alerts" role="tab" aria-controls="nav-alerts" aria-selected="false"><i class="fe fe-bell-off"></i>&nbsp;Alerts</a>
											<?php if($category_array['parent_category']->name == "Loans"){ ?>
												<a class="nav-item nav-link text-left" id="nav-contact-tab" data-toggle="tab" href="#nav-amortization" role="tab" aria-controls="nav-contact" aria-selected="false"><i class="fe fe-calendar"></i>&nbsp;Loan Amortization</a>
											<?php } ?>
										</div>
									</nav>
								</div>
								<div class="card-body" style="background: whitesmoke;">
									<div class="tab-content" id="nav-tabContent">
										<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
											<div class="card">
												<div class="card-body">
													<?php include '_account_statement.php'; ?>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
											<div class="card">
												<div class="card-body">
													<?php include '_account_attachments.php'; ?>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
											<div class="card">
												<div class="card-body">
													<?php include '_account_details.php'; ?>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="nav-alerts" role="tabpanel" aria-labelledby="nav-alerts-tab">
											<div class="card">
												<div class="card-body">
													<?php include '_account_alerts.php'; ?>
												</div>
											</div>
										</div>
										<?php if($category_array['parent_category']->name == "Loans"){ ?>
											<div class="tab-pane fade" id="nav-amortization" role="tabpanel" aria-labelledby="nav-profile-tab">
												<div class="card">
													<div class="card-body">
														<?php include '_account_amortization.php'; ?>
													</div>
												</div>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 print-wide">
				<?php if (auth_check() && is_admin()){
					$deposit_text = "Deposit";
					$withdraw_text = "Withdraw";

					if($category_array['parent_category']->name == "Loans"){
						$deposit_text = "Repay Loan";
						$withdraw_text = "Loan Top Up";
					}
					?>
					<div class="card hidden-print">
						<div class="card-body px-3 py-1">
							<h4 class="text-left" style="color: black;border-right:none;line-height: unset;margin: 0;font-weight: bolder;"><small>ACTIONS</small></h4>
							<div class="row make_transaction">
								<div class="col-12 delete_button action"></div>
								<div class="col-12 deposit_button action">
									<button class="btn btn-success text-left" style="width: 100%;" type="button" onclick="$('#depositForm').fadeIn();">
										<i class="fe fe-plus"></i>&nbsp;&nbsp; <?= $deposit_text ?>
									</button>
								</div>
							</div>
							<div class="row">
								<?php 
								$firsttransaction = $this->post_model->getfirsttransactiondate($post->id);
								if(null !== $firsttransaction){
									$startdate = date('Y-m-d', strtotime($firsttransaction));
								}else{
									$startdate = date('Y-m-d', strtotime($post->startdate));
								}
								if($post->interestrate !== "0"){
									if(isset($startdate) || (isset($startdate) && date('Y-m-d', strtotime($startdate)) < date('Y-m-d'))){ 
										if(!isset($_GET['refresh'])){ ?>
											<div class="col-12 refresh_button action">
												<a href="?refresh=true">
													<button class="btn btn-secondary text-left" type="button" style="width: 100%;"><i class="fe fe-refresh-cw"></i>&nbsp;&nbsp; Recalculate Interest</button>
												</a>
											</div>
										<?php } 
									}
								} ?>
								<div class="col-12 print_button action">
									<button class="btn btn-default text-left" type="button" style="width: 100%;" onclick="print();"><i class="fe fe-printer"></i>&nbsp;&nbsp; Print Statement</button>
								</div>
								<div class="col-12 mail_button action">
									<button class="btn btn-default text-left" type="button" style="width: 100%;" onclick="send_statement('admin_controller/send_statement','<?= $post->id; ?>','Send electronic statement');"><i class="fe fe-mail"></i>&nbsp;&nbsp; Send eStatement</button>
								</div>
							</div>
							<div class="card-footer px-0 py-1">
								<div class="row">
									<div class="col-12 withdraw_button action">
										<?php if(count($comments) > 0){ ?>
											<a href="#" onclick="$('#withdrawForm').fadeIn();">
												<button class="btn btn-primary text-left" style="width: 100%;" type="button">
													<i class="fe fe-minus"></i>&nbsp;&nbsp; <?= $withdraw_text ?>
												</button>
											</a>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<div class="card monthly_interest <?php if($post->interestrate == '0'){ echo 'hide'; } ?>" style="overflow-x: hidden;">
					<div class="card-body p-0">
						<table class="table table-striped table table-hover table-outline table-vcenter text-nowrap card-table datatable" role="grid" style="margin: 0;max-width: 100%;">
							<thead>
								<th colspan="2">
									<h4 class="text-left" style="color: black;border-right:none;line-height: unset;margin: 0;font-weight: bolder;"><small>MONTHLY INTEREST</small></h4>
								</th>
							</thead>
							<tbody>
								<?php
								$begin = new DateTime(date('Y-m-d', strtotime($startdate)));
								$end = new DateTime(date('Y-m-d'));

								$interval = DateInterval::createFromDateString('1 day');
								$period = new DatePeriod($begin, $interval, $end);

								$closed = 0;

								$total = 0;
								$interest_earned = 0;

								foreach ($period as $dt) { 
									$total = $total + 1;
									if($dt->format("d") == "01"){
										$intr = $this->post_model->getinterestearned($dt->format('Y-m-d'), $post->id, $total);
										if($post->category_id == 2 && $intr < 0 || $post->category_id !== 2){
											$interest_earned = $interest_earned + $intr;
											if($intr == 0){
												$closed = 1;
												break;
											}
											if($intr !== 0){  ?>
												<tr>
													<td class="text-left"><?= date('F Y', strtotime( '-1 day' ,strtotime($dt->format("d F Y\n")))) ?></td>
													<?php /* <td class="text-center"><?= $total ?></td> */ ?>
													<td class="text-right"><?= $post->currency ?> <?= positive_number($intr) ?></td>
												</tr>
											<?php }
											$total = 0; 
										}
									}
								}

								// Temporarily disable closing accounts prematurely
								if($closed == 1) $closed = 0;

								?>
								<?php
								if(date("d") !== "01" && $closed == 0){
									$intr = $this->post_model->getinterestearned(date('Y-m-d'), $post->id, $total);
									if($post->category_id == 2 && $intr < 0 || $post->category_id !== 2){
										$interest_earned = $interest_earned + $intr;
										if($intr !== 0){  ?>
											<tr>
												<td class="text-left"><?= date('F Y', strtotime( '-1 day' ,strtotime(date("d F Y\n")))) ?></td>
												<?php /* <td class="text-center"><?= $total ?></td> */ ?>
												<td class="text-right"><?= $post->currency ?> <?= positive_number($intr) ?></td>
											</tr>
										<?php }
										$total = 0;
									}
								}
								if($closed == 1 && ($post->interestrate * 1) !== 0){ ?>
									<script>
										$('.deposit_button').hide();
										$('.withdraw_button').hide();
										$('.make_transaction').remove();
									</script>
								<?php } ?>
								<td class="text-left"><strong>TOTAL</strong></td>
								<?php /* <td class="text-center"></td> */ ?>
								<td class="text-right"><strong><?= $post->currency ?> <?= positive_number($interest_earned) ?></strong></td>
							</tbody>
						</table>
						<script type="text/javascript" class="remover">
							<?php
							$closingbalance = 0;
							$running = 0;
							if(isset($post->running)){
								$running = $post->running;
							}

							$running = $this->post_model->get_closing_balance($post->id, date('Y-m-d'));

							if($interest_earned > 0 || $interest_earned < 0){

								$closingbalance = $interest_earned + $post->running;	
								
								if($post->category_id == 2 && ($closingbalance * 1) > 0){
									$closingbalance = 0;
									$running = 0;
								}

								?> 
								
								$('#interest').html('<?= $post->currency.' '.positive_number($interest_earned); ?>');
								$('#closing_balance').html('<?= $post->currency.' '.positive_number($closingbalance); ?>');
								$('#principal').html('<?= $post->currency.' '.positive_number($running); ?>')
							<?php }else{ ?>
								$('#interest').html('<?= $post->currency.' '.positive_number(0); ?>');
								$('#closing_balance').html('<?= $post->currency.' '.positive_number($running); ?>');
								$('#principal').html('<?= $post->currency.' '.positive_number($running); ?>')
							<?php } 
							if($post->category_id == 2 && ($running * 1) == 0){ ?>
								<?php if(null !== $post->interestrate && ($post->interestrate * 1) !== 0){ ?>
									// TODO: Keep them open until we confirm that it's supposed to be closed
									// $('.withdraw_button').hide();
									// $('.deposit_button').hide(); 
								<?php } ?>
								$('.progress-bar').css('width','100%');
							<?php }
							if($post->category_id == 1 && $closingbalance == 0){ ?>
								$('.refresh_button').remove();
								$('.print_button').remove();
							// $('.monthly_interest').remove();

							// $('table#interest_table').remove();
							// $('table#principal_table').remove();
							
							// $('.delete_button').html('Hello there!!!');
						<?php } ?>
						<?php 

						?>

						currency = '<?= $post->currency ?>';
						interest = '<?= positive_number($interest_earned - $interest_drawn) ?>';
						principal = '<?= positive_number($running) ?>';
						accountbalance = '<?= positive_number($closingbalance) ?>';
						$('.draw_amount').html(currency+' '+interest);
					</script>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
<!-- /.Section: main -->
<script>
	$(".amount").keyup(function(event) {
	     // skip for arrow keys
	     if(event.which >= 37 && event.which <= 40){
	     	let val = $(this).val();
	     	if(val > 500000000){
	     		$(this).val(500000000);
	     	}
	     	return;
	     }

	     // format number
	     $(this).val(function(index, value) {
	     	return value
	     	.replace(/\D/g, "")
	     	.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
	     	;
	     });

	     var firstValue = Number($('#amount').val().replace(/,/g,''));
	     //console.log(firstValue);
	 });
	<?php if (auth_check() && is_admin()){ ?>
		function delete_transaction(url, id, message){
			Swal.fire({
				title: 'Are you sure?',
				text: 'You really want to delete this transaction?',
				type: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes, delete it!',
				cancelButtonText: 'No, keep it'
			}).then((result) => {
				console.log(result);
				if (result.value) {
					var data = {'id': id, };
					data[csfr_token_name] = $.cookie(csfr_cookie_name);
					$.ajax({
						type: "POST",
						url: base_url + url,
						data: data,
						success: function (response) {location.reload(); }
					});
				} else if (result.dismiss === Swal.DismissReason.cancel) {
					Swal.fire('Canceled', 'Transaction saved', 'success');
				}
			});
		}

		function send_statement(url, id, message){
			Swal.fire({
				title: 'Send Statement',
				text: 'Do you want to send a statement to <?= $post->owner->email ?>?',
				type: 'question',
				showCancelButton: true,
				confirmButtonText: 'Send it!',
				cancelButtonText: 'Cancel'
			}).then((result) => {
				console.log(result);
				if (result.value) {
					var data = {'id': id, 'email': '<?= $post->owner->email ?>' };
					data[csfr_token_name] = $.cookie(csfr_cookie_name);
					$.ajax({
						type: "POST",
						url: base_url + url,
						data: data,
						success: function (response) {
							Swal.fire('Done', 'Statement sent', 'success');
						}
					});
				} else if (result.dismiss === Swal.DismissReason.cancel) {
					Swal.fire('Canceled', 'Action canceled', 'success');
				}
			});
		}
	<?php } ?>
</script>