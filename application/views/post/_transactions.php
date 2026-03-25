		<table id="transactions" class="table table-striped table table-hover table-outline table-vcenter text-nowrap card-table datatable" role="grid" style="background: white; max-width: 100%;">
			<thead>
				<tr role="row">
					<th width="10">NO.</th>
					<!-- <th>TYPE</th> -->
					<th>NARRATION</th>
					<th style="min-width: 10%"><?= trans('date'); ?></th>
					<!-- <th style="min-width: 10%">TIME</th> -->
					<th width="160" class="text-center">
					DR</th>
					<th width="160" class="text-center">
					CR</th>
					<th width="160" class="text-center">
					Balance</th>
					<?php if (user()->role == 'admin'){ ?>
						<th class="hidden-print"></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php $running = 0; $dr = 0; $cr = 0; 
				$category_array = get_category_array($post->category_id);
				$i=1; foreach ($comments as $item):
				switch ($category_array['parent_category']->name) {case 'Deposits': if($item->trans_type == 'CR'){$ttype = 'Deposit'; }else{$ttype = 'Withdraw'; } break; case 'Loans': if($item->trans_type == 'DR'){$ttype = 'Withdraw'; }else{$ttype = 'Deposit'; } break; }
				?>
				<tr>
					<td class="text-right"><?= html_escape($i); $i++; ?>.</td>
					<!-- <td class="break-word"><?= html_escape($ttype); ?></td> -->
					<td class=""><?= html_escape($item->comment); ?></td>
					<td class="text-center"><?= formatted_date($item->trans_date); ?></td>
					<td class="text-right">
						<?php if($item->trans_type == 'DR'){
							$dr = $dr + $item->amount;
							$running = $running - $item->amount;
							echo html_escape($item->currency).' '.positive_number($item->amount);
						}else{
							echo '';
						} ?>
					</td>
					<td class="text-right">
						<?php if($item->trans_type == 'CR'){
							$cr = $cr + $item->amount;
							$running = $running + $item->amount;
							echo html_escape($item->currency).' '.positive_number($item->amount);
						} ?>
					</td>
					<td class="text-right">
						<?php
						$closing = $this->post_model->get_closing_balance_on_date($post->id, $item->trans_date);
						$item->closing_balance = $closing;
						echo html_escape($item->currency).' '.positive_number($closing);
						?>
					</td>
					<?php if (user()->role == 'admin'){ ?>
						<td class="hidden-print p-0">
							<?php echo form_open('post_controller/post_options_post'); ?>
							<input type="hidden" name="id" value="<?= html_escape($item->id); ?>">
							<div class="input-group">
								<button type="button" class="btn btn-default btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: none;background: transparent;color:grey;"><i class='fe fe-chevron-down'></i></button>
								<div class="dropdown-menu p-0" style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
									<?php if($item->trans_type == "CR"){ ?>
										<a class="dropdown-item" href="<?= base_url() ?>receipt/<?= $item->id ?>"><i class="dropdown-icon fe fe-printer"></i> View Receipt</a>
									<?php }else{ ?>
										<a class="dropdown-item" href="<?= base_url() ?>transaction/<?= $item->id ?>"><i class="dropdown-icon fe fe-printer"></i> View Transaction</a>
									<?php } ?>
									<a class="dropdown-item" href="javascript:void(0)"><i class="dropdown-icon fe fe-edit"></i> Edit Transaction</a>
									<?php if (auth_check() && is_admin()){ ?>
										<div role="separator" class="dropdown-divider"></div>
										<a class="dropdown-item color-red" href="javascript:void(0)" onclick="delete_transaction('admin_controller/delete_transaction','<?= $item->id; ?>','<?= trans("confirm_comment"); ?>');"><i class="dropdown-icon fe fe-trash"></i> Delete Transaction</a>
									<?php } ?>
								</div>
							</div>
							<?= form_close(); ?><!-- form end -->
						</td>
					<?php } ?>
				</tr>
			<?php endforeach; $post->running = $running; ?>
			<tr>
				<td class="text-right"></td>
				<td class="break-word">TOTAL</td>
				<!-- <td class="break-word"></td> -->
				<td class=""></td>
				<td class="text-right"><?php if($dr > 0) echo $post->currency.' '.number_format(html_escape($dr)); ?></td>
				<td class="text-right"><?php if($cr > 0) echo  $post->currency.' '.number_format(html_escape($cr)); ?></td>
				<td class="text-right"></td>
				<?php if (user()->role == 'admin'){ ?>
					<td class="text-right hidden-print"></td>
				<?php } ?> 
			</tr>
		</tbody>
	</table>
	<script>
		<?php 
		switch ($category_array['parent_category']->name) {
			case 'Deposits': 
			$deposits = $cr - $comments[0]->amount;
			$withdrawals = $dr;
			break; 
			case 'Loans': 
			$deposits = $dr - $comments[0]->amount;
			$withdrawals = $cr;
			break; 
		}
		?>
		$('#deposits').html("<?= $post->currency.' '.number_format(html_escape($deposits)) ?>");
		$('#withdrawals').html("<?= $post->currency.' '.number_format(html_escape($withdrawals)) ?>");
	</script>
	<div class="card-footer">
		<div class="form-group">
			<div class="pull-right">
				<?= $this->pagination->create_links(); ?>
			</div>
		</div>
	</div>
