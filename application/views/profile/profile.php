<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: main -->
<section id="main">
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">
					<?= html_escape($user->firstname).' '.html_escape($user->lastname); ?>
				</h3>
				<div class="card-options">
					<a href="<?= base_url() ?>user/<?= $user->id ?>">
						<button class="btn btn-success btn-sm btn-add-new" type="button">
							<i class="fe fe-edit"></i> Edit User</button>
						</a>
					</div>
				</div>
				<div class="card-body pb-0">
					<div class="profile-page-top">
						<!-- load profile details -->
						<div class="profile-details row">
							<div class="col-sm-12 col-md-4 col-lg-3">
								<?php $this->load->view("profile/_profile_user_info"); ?>
							</div>
							<div class="col-sm-12 col-md-8 col-lg-9">
								<div class="profile-page">
									<h2 class="text-center">Accounts</h2>
									<div class="row">
										<div class="col-12">

											<table class="table table-hover table-outline table-vcenter text-nowrap card-table" role="grid">
												<thead>
													<tr role="row">
														<th>
															<?= trans('category'); ?>
														</th>
														<th>Amount</th>
														<th>Interest Rate</th>
														<th>Period</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>


													<?php foreach ($posts as $item): ?>
														<tr>
															<?php $author = get_user($item->userid); ?>
															<td>
																<a href="<?= base_url(); ?><?= html_escape($item->title_slug); ?>">
																	<div class="row">
																		<div class="col-12">
																			<?php if($item->category_id == 1){ echo 1010000 + $item->id; }else{ echo 2010000 + $item->id; } ?>
																		</div>
																		<div class="col-12" style="font-size: 12px;color: gray;margin-top: -5px;">
																			<?php
																			$category_array = get_category_array($item->category_id);
																			if (!empty($category_array['parent_category'])):?>
																				<?= html_escape($category_array['parent_category']->name); ?>
																			<?php endif; ?>
																		</div>
																	</div>
																</a>
															</td>

															<td><?= html_escape($item->currency); ?> <?= number_format(html_escape($item->amount)); ?>

														</td>
														<td><?= html_escape($item->interestrate); ?>% <?= html_escape($item->interestperiod); ?>

													</td>

													<td>
														<?php 

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
																<small class="text-muted"><?= formatted_date($item->startdate, 'M d, Y'); ?> - <?= formatted_date($item->enddate, 'M d, Y'); ?></small>
															</div>
														</div>
														<div class="progress progress-xs">
															<div class="progress-bar bg-yellow" role="progressbar" style="width: <?= $percent ?>%" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"></div>
														</div>
													</td>

													<td>
														<!-- form post options -->
														<?= form_open('post_controller/post_options_post'); ?>
														<input type="hidden" name="id" value="<?= html_escape($item->id); ?>">
														<div class="item-action dropdown pull-right">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>
															<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(15px, 20px, 0px); top: 0px; left: 0px; will-change: transform;">
																<a href="<?= base_url(); ?><?= html_escape($item->title_slug); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> View Statement</a>

																<!-- <div class="dropdown-divider"></div> -->

															</div>
														</div>

														<?php /*
														<div class="dropdown">
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
														</div> */ ?>

														<?= form_close(); ?><!-- form end -->
													</td>
												</tr>
											<?php endforeach; ?>

										</tbody>
									</table>
								</div>
							</div><!-- /.posts -->
						</div>
						<div class="col-xs-12 col-sm-12 col-xs-12">
							<div class="row">
								<?php $this->load->view("partials/_ad_spaces", ["ad_space" => "profile_bottom"]); ?>
							</div>
						</div>
						<!-- Pagination -->
						<div class="col-xs-12 col-sm-12 col-xs-12">
							<div class="row">
								<?= $this->pagination->create_links(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
<!-- /.Section: main -->


