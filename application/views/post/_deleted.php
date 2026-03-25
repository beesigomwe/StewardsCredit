		<table class="table table-striped table table-hover table-outline table-vcenter text-nowrap card-table datatable" role="grid" style="background: #fff4fd;">
			<thead style="background: #ffe0f0;">
				<tr role="row">
					<th width="10">NO.</th>
					<!-- <th>TYPE</th> -->
					<th>NARRATION</th>
					<th style="min-width: 10%"><?= trans('date'); ?></th>
					<th width="160" class="text-center">
					DR</th>
					<th width="160" class="text-center">
					CR</th>
					<?php if (user()->role == 'admin'){ ?>
						<th class="hidden-print" colspan="2"></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php 
				$category_array = get_category_array($post->category_id);
				$i=1; foreach ($deleted as $item):
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
					<?php if (user()->role == 'admin'){ ?>
						<td class="p-0">
							<?php if ($item->status != 1): ?>
								<?= form_open('admin_controller/approve_comment_post'); ?>
								<input type="hidden" name="id" value="<?= $item->id; ?>">
								<li class="dropdown-item p-0">
									<button class="btn btn-secondary btn-sm px-4" type="submit"><i class="dropdown-icon fe fe-rotate-ccw"></i> Restore</button>
								</li>
								<?= form_close(); ?>
							<?php endif; ?>
						</td>
						<td class="p-0 px-1">
							<?php if ($item->status != 1): ?>
								<a class="btn btn-secondary btn-sm px-4 color-red text-center" href="javascript:void(0)" onclick="delete_transaction('admin_controller/delete_comment_post','<?= $item->id; ?>','<?= trans("confirm_comment"); ?>');"><i class="fe fe-trash-2" data-toggle="tooltip" title="" data-original-title="Delete Transaction"></i></a>
							<?php endif; ?>
						</td>
					<?php } ?>
				</tr>
			<?php endforeach; ?>

		</tbody>
	</table>