<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
	<!-- include message block -->
	<div class="col-sm-12">
		<?php $this->load->view('admin/includes/_messages'); ?>
	</div>
</div>
<div class="card">
	<div class="card-header">
		<h3 class="card-title"><?= $title; ?></h3>
		<div class="card-options">
			<a href="<?= admin_url(); ?>create-account?category=<?=$this->input->get('category')?>">
				<button class="btn btn-success btn-sm btn-add-new"type="button">
					<i class="fe fe-plus"></i> <?= trans('add_post'); ?>
				</button>
			</a>
		</div>
	</div>
	<div class="">
		<table class="table table-striped table table-hover table-outline table-vcenter text-nowrap card-table" style="background: whitesmoke; border-bottom: 1px solid gainsboro; "> 
			<tbody>
				<tr>
					<td>
						<?php $this->load->view('admin/includes/_filter_posts'); ?>
					</td>
				</tr>
			</tbody>
		</table>
		<table class="table table-striped table table-hover table-outline table-vcenter text-nowrap card-table" role="grid">
			<thead>
				<tr role="row">
					<th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
					<th width="20"><?= trans('id'); ?></th>
					<th><?= trans('user'); ?></th>
					<th>ACCOUNT</th>
					<th>Amount</th>
					<th>Interest Rate</th>
					<th>Period</th>
					<th></th>
				</tr>
			</thead>
			<tbody>

				<?php foreach ($posts as $item): ?>
					<tr>
						<td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?= $item->id; ?>"></td>
						<td><?= html_escape($item->id); ?></td>
						<td>
							<?php $author = get_user($item->userid);
							if (!empty($author)): ?>
								<a href="<?= base_url(); ?>profile/<?= html_escape($author->slug); ?>" target="_parent" class="table-link">
									<strong><?= html_escape($author->firstname.' '.$author->lastname); ?></strong>
								</a>
							<?php endif; ?>
						</td>

						<td>
							<a href="<?=base_url().$item->title_slug ?>">
								<?php
								$category_array = get_category_array($item->category_id); ?>
								<?php if($item->category_id == 1){ echo 1010000 + $item->id; }else{ echo 2010000 + $item->id; } ?><br>
								<?php if (!empty($category_array['parent_category'])):?>
									<small class="text-muted" style="margin-top: -7px;display: block;"><?= html_escape($category_array['parent_category']->name); ?></small>
								<?php endif; ?>
							</a>
						</td>

						<td><?= html_escape($item->currency); ?> <?= positive_number(html_escape($item->amount)); ?></td>
						<td><?= html_escape($item->interestrate); ?>% <?= html_escape($item->interestperiod); ?></td>
						
						<?php /*
						<td class="td-post-sp">
							<?php if ($item->visibility == 1): ?>
								<label class="label label-success label-table"><i class="fa fa-eye"></i></label>
								<?php else: ?>
									<label class="label label-danger label-table"><i class="fa fa-eye"></i></label>
								<?php endif; ?>

								<?php if ($item->is_slider): ?>
									<label class="label bg-olive label-table"><?= trans('slider'); ?></label>
								<?php endif; ?>

								<?php if ($item->is_picked): ?>
									<label class="label bg-aqua label-table"><?= trans('our_picks'); ?></label>
								<?php endif; ?>

								<?php if ($item->need_auth): ?>
									<label class="label label-warning label-table"><?= trans('only_registered'); ?></label>
								<?php endif; ?>

								</td> */ ?>

								<td>
									<?php 
									if(date('Y-m-d', strtotime($item->enddate)) > date('Y-m-d')){
										$now = strtotime(date('Y-m-d H:i:s')); 
										$start = strtotime($item->startdate);
										$end = strtotime($item->enddate);
										$elpsed = $now - $start; 
										$period = $end - $start;

										$da = round($elpsed / (60 * 60 * 24));
										$ys = round($period / (60 * 60 * 24));

										$percent = 0;
										if($da > 0) $percent = round(($da/$ys) * 100);
										?>
										<div class="clearfix">
											<div class="float-left">
												<strong><?= $percent ?>%</strong>
											</div>
											<div class="float-right">
												<small class=""><?= formatted_date($item->startdate, 'M d, Y'); ?> - <?= formatted_date($item->enddate, 'M d, Y'); ?></small>
											</div>
										</div>
										<div class="progress progress-xs">
											<div class="progress-bar bg-yellow" role="progressbar" style="width: <?= $percent ?>%" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									<?php }else{
										echo 'From '.date('d F Y', strtotime($item->startdate));
									} ?>
								</td>

								<td>
									<!-- form post options -->
									<?= form_open('post_controller/post_options_post'); ?>
									<input type="hidden" name="id" value="<?= html_escape($item->id); ?>">


									<div class="item-action dropdown pull-right">
										<a href="javascript:void(0)" data-toggle="dropdown" class="icon" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>
										<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(15px, 20px, 0px); top: 0px; left: 0px; will-change: transform;">
											<a href="<?= base_url(); ?>profile/<?= html_escape($author->slug); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> View </a>

											<div class="dropdown-divider"></div>

										</div>
									</div>


									<!-- <div class="dropdown">
										<button class="btn bg-purple dropdown-toggle btn-select-option"
										type="button"
										data-toggle="dropdown"><?= trans('select_option'); ?>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu options-dropdown">
										<li>
											<a href="<?= admin_url(); ?>update-post/<?= html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
										</li>
										<?php if (is_admin()): ?>
											<?php if ($item->is_picked == 1): ?>
												<li>
													<button type="submit" name="option" value="add-remove-from-picked" class="btn-list-button">
														<i class="fa fa-times option-icon"></i><?= trans('remove_picked'); ?>
													</button>
												</li>
												<?php else: ?>
													<li>
														<button type="submit" name="option" value="add-remove-from-picked" class="btn-list-button">
															<i class="fa fa-plus option-icon"></i><?= trans('add_picked'); ?>
														</button>
													</li>
												<?php endif; ?>

											<?php endif; ?>
											<li>
												<a href="javascript:void(0)" onclick="delete_item('post_controller/delete_post','<?= $item->id; ?>','<?= trans("confirm_post"); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
											</li>
										</ul>
									</div> -->

									<?= form_close(); ?><!-- form end -->
								</td>
							</tr>
						<?php endforeach; ?>

					</tbody>
				</table>
				<div class="card-footer">
					<div class="form-group">
						<?php /* if (count($posts) > 0): ?>
							<button class="btn btn-secondary btn-table-delete" onclick="delete_selected_posts('<?= trans("confirm_posts"); ?>');"><?= trans('delete'); ?></button>
						<?php endif; */ ?>
						<div class="pull-right">
							<?= $this->pagination->create_links(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>


		<style>
			.options-dropdown {
				left: -40px;
			}
		</style>
