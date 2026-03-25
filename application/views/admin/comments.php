<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<!-- include message block -->
	<div class="col-sm-12">
		<?php $this->load->view('admin/includes/_messages'); ?>
	</div>
</div>
<div class="row">
	<div class="card">
		<div class="col-12">
			<div class="card-header">
				<div class="left">
					<h3 class="card-title"><?= $title; ?></h3>
				</div>
			</div><!-- /.box-header -->

			<div class="table-responsive">
				<table class="table table-striped table table-hover table-outline table-vcenter text-nowrap card-table">
					<thead>
						<tr role="row">
							<th width="20"><?= trans('id'); ?></th>
							<th>CLIENT</th>
							<th>ACCOUNT</th>
							<th style="min-width: 20%">NARRATION</th>
							<th class="text-center" style="min-width: 10%"><?= trans('date'); ?></th>
							<th class="text-center">TYPE</th>
							<th class="text-right">AMOUNT</th>
							<th></th>
						</tr>
					</thead>
					<tbody>

						<?php foreach ($comments as $item): ?>
							<tr>
								<?php $post = $this->post_model->get_post_by_id($item->post_id); 
								$item->account = $post; ?>
								<td><?= $item->id ?></td>
								<td><?= $item->account->fullname ?><br></td>
								<td>
									<a href="<?= base_url().$post->title_slug ?>">
										<?php if($post->category_id == 1){ echo 1010000 + $post->id; }else{ echo 2010000 + $post->id; } ?><br>
										<small style="margin-top: -5px;"><?= $item->account->category->name ?></small>
									</a>
								</td>
								<td class="break-word"><?= html_escape($item->comment); ?></td>
								<td class="nowrap text-center"><?= formatted_date($item->created_at); ?></td>
								<td class="text-center"><?= strtoupper(html_escape($item->trans_type)); ?></td>
								<td class="text-right">
									<?= $item->currency ?> <?= number_format($item->amount) ?>
								</td>
								<td class="w-2">
									<?php if ($item->status != 1){ ?>
										<?= form_open('admin_controller/approve_comment_post'); ?>
										<input type="hidden" name="id" value="<?= $item->id; ?>">
										<div class="dropdown">
											<button class="btn btn-secondary btn-sm dropdown-toggle"
											type="button"
											data-toggle="dropdown" style="font-weight: 400;">Actions
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu options-dropdown">
											<?php if ($item->status != 1): ?>
												<li class="dropdown-item">
													<button class="transparent" type="submit"><i class="dropdown-icon fe fe-check option-icon"></i> <?= trans("approve"); ?></button>
												</li>
												<div class="dropdown-divider"></div>
												<li class="dropdown-item">
													<a href="javascript:void(0)" onclick="delete_transaction('admin_controller/delete_comment_post','<?= $item->id; ?>','<?= trans("confirm_comment"); ?>');" style="color: red;"><i class="dropdown-icon fe fe-trash option-icon" style="color: red;"></i> <?= trans('delete'); ?></a>
												</li>
											<?php endif; ?>
										</ul>
									</div>
									<?= form_close(); ?><!-- form end -->
								<?php }else{ ?>
									<?= form_open('admin_controller/approve_comment_post'); ?>
									<input type="hidden" name="id" value="<?= $item->id; ?>">
									<div class="dropdown">
										<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" style="font-weight: 400;">Actions
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu options-dropdown">
											<?php if ($item->status != 1): ?>
												<li class="dropdown-item">
													<button class="transparent" type="submit"><i class="dropdown-icon fe fe-check option-icon"></i> <?= trans("approve"); ?></button>
												</li>
												<div class="dropdown-divider"></div>
												<li class="dropdown-item">
													<a href="javascript:void(0)" onclick="delete_transaction('admin_controller/delete_comment_post','<?= $item->id; ?>','<?= trans("confirm_comment"); ?>');" style="color: red;"><i class="dropdown-icon fe fe-trash option-icon" style="color: red;"></i> <?= trans('delete'); ?></a>
												</li>
											<?php endif; ?>
										</ul>
									</div>
									<?= form_close(); ?><!-- form end -->
								<?php } ?>
							</td>
						</tr>

					<?php endforeach; ?>

				</tbody>
			</table>
		</div>
		<?php /*
		<div class="col-sm-12">
			<div class="row">
				<div class="pull-left">
					<button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_comments('<?= trans("confirm_comments"); ?>');"><?= trans('delete'); ?></button>
					<?php if ($show_approve_button == true): ?>
						<button class="btn btn-sm btn-success btn-table-delete" onclick="approve_selected_comments();"><?= trans('approve'); ?></button>
					<?php endif; ?>
				</div>
			</div>
		</div>
		*/ ?>
	</div><!-- /.box-body -->
</div>
</div>

<script type="text/javascript">
	function delete_transaction(url, id, message){
		Swal.fire({
			title: 'Are you sure?',
			text: 'You really want to delete this transaction!',
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes, delete it!',
			cancelButtonText: 'No, keep it'
		}).then((result) => {
			console.log(result);
			if (result.value) {
				var data = {
					'id': id,
				};
				data[csfr_token_name] = $.cookie(csfr_cookie_name);
				$.ajax({
					type: "POST",
					url: base_url + url,
					data: data,
					success: function (response) {
						location.reload();	
					}
				});
			} else if (result.dismiss === Swal.DismissReason.cancel) {
				Swal.fire(
					'Canceled',
					'Transaction saved',
					'success'
					)
			}
		});
	}
</script>