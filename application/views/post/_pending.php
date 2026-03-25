		<table class="table table-striped table table-hover table-outline table-vcenter text-nowrap card-table datatable" role="grid" style="background: #fffef4;">
			<thead>
				<tr role="row">
					<th width="10">NO.</th>
					<!-- <th>TYPE</th> -->
					<th>NARRATION</th>
					<th style="min-width: 10%"><?= trans('date'); ?></th>
					<th width="160" class="text-center">
					DR</th>
					<th width="160" class="text-center">
					CR</th>
					<th width="160" class="text-center">
					Status</th>
					<?php if (user()->role == 'admin'){ ?>
						<th class="hidden-print" colspan="2"></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php 
				$category_array = get_category_array($post->category_id);
				$i=1; foreach ($pending as $item):
				switch ($category_array['parent_category']->name) {case 'Deposits': if($item->trans_type == 'CR'){$ttype = 'Deposit'; }else{$ttype = 'Withdraw'; } break; case 'Loans': if($item->trans_type == 'DR'){$ttype = 'Withdraw'; }else{$ttype = 'Deposit'; } break; }
				?>
				<tr>
					<td class="text-right"><?= html_escape($i); $i++; ?>.</td>
					<!-- <td class="break-word"><?= html_escape($ttype); ?></td> -->
					<td class="break-word"><?= html_escape($item->comment); ?></td>
					<td class="nowrap text-center"><?= formatted_date($item->trans_date); ?></td>
					<td class="text-right">
						<?php if($item->trans_type == 'DR'){
							echo html_escape($item->currency).' '.positive_number($item->amount);
						}else{
							echo '';
						} ?>
					</td>
					<td class="text-right">
						<?php if($item->trans_type == 'CR'){
							echo html_escape($item->currency).' '.positive_number($item->amount);
						} ?>
					</td>
					<td class="text-center">
						Pending
					</td>
					<?php if (user()->role == 'admin'){ ?>
						<td class="hidden-print">
							<?php echo form_open('post_controller/post_options_post'); ?>
							<input type="hidden" name="id" value="<?= html_escape($item->id); ?>">
							<div class="input-group">
								<button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: none;background: transparent;">Options</button>
								<div class="dropdown-menu" style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
									<?php if($item->trans_type == "CR"){ ?>
										<a class="dropdown-item" href="<?= base_url() ?>receipt/<?= $item->id ?>"><i class="dropdown-icon fe fe-printer"></i> View Receipt</a>
									<?php }else{ ?>
										<a class="dropdown-item" href="<?= base_url() ?>transaction/<?= $item->id ?>"><i class="dropdown-icon fe fe-printer"></i> View Transaction</a>
									<?php } ?>
									<a class="dropdown-item" href="javascript:void(0)"><i class="dropdown-icon fe fe-edit"></i> Edit Transaction</a>
									<?php if (auth_check() && is_admin()){ ?>
										<div role="separator" class="dropdown-divider"></div>
										<a class="dropdown-item color-red" href="javascript:void(0)" onclick="delete_transaction('admin_controller/delete_comment_post','<?= $item->id; ?>','<?= trans("confirm_comment"); ?>');"><i class="dropdown-icon fe fe-trash"></i> Delete Transaction</a>
									<?php } ?>
								</div>
							</div>
							<?= form_close(); ?><!-- form end -->
						</td>
						<td class="p-0">
							<?php if ($item->status != 1): ?>
								<?= form_open('admin_controller/approve_comment_post'); ?>
								<input type="hidden" name="id" value="<?= $item->id; ?>">
								<li class="dropdown-item p-0">
									<button class="btn btn-secondary btn-sm px-4" type="submit"><i class="dropdown-icon fe fe-check option-icon"></i> <?= trans("approve"); ?></button>
								</li>
								<?= form_close(); ?>
							<?php endif; ?>
						</td>
					<?php } ?>
				</tr>
			<?php endforeach; ?>

		</tbody>
	</table>