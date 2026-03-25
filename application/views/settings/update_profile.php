<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: main -->
<section id="main">
	<div class="container">
		<!-- breadcrumb -->
		<?php /* <div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= lang_base_url(); ?>"><?= trans("home"); ?></a></li>
				<li class="breadcrumb-item"><a href="<?= lang_base_url(); ?>settings"><?= trans("settings"); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
			</ol>
			</div> */ ?>

			<div class="page-content">
				<div class="row">
					<div class="col">
						<?php $this->load->view('partials/_messages'); ?>
					</div>
				</div>

				<div class="card">
					<div class="card-header">
						<h3 class="card-title"><?= $user->firstname.' '.$user->lastname; ?></h3>
						<div class="card-options">

						</div>
					</div>

					<div class="card-body">
						<!-- include message block -->
						<?= form_open_multipart("profile_controller/update_profile_post", ['id' => 'form_validate']); ?>
						<div class="row">
							<div class="col-auto text-center">
								<img src="<?= get_user_avatar($user); ?>" alt="<?= $user->username; ?>" class="avatar-xxl" style="width: 100px;height: 100px;margin: 0 auto; left: 0; right: 0; border-radius: 5px;">
								<div class="form-group" style="margin-top: 8px;">
									<a class='btn btn-secondary btn-file-upload btn-profile-file-upload' style="position: relative;">
										Upload Photo
										<input style="position: absolute;background: orange;z-index: 100;bottom: 0;left: 0;" type="file" class="custom-file-input" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" onchange="$('#upload-file-info').html($(this).val().replace(/.*[\/\\]/, '..'));">
									</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?= $user->id ?>">
							<div class="col">
								<div class="row">
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label class="form-label">First Name</label>
											<input type="text" name="firstname" class="form-control" placeholder="Company" value="<?= $user->firstname ?>">
										</div>
									</div>
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label class="form-label">Last Name</label>
											<input type="text" name="lastname" class="form-control" placeholder="Last Name" value="<?= $user->lastname ?>">
										</div>
									</div>
									<div class="col-sm-6 col-md-7">
										<div class="form-group">
											<label class="form-label">Email address</label>
											<input type="email" name="email" class="form-control" placeholder="Email" value="<?= $user->email ?>">
										</div>
									</div>
									<div class="col-sm-6 col-md-5">
										<div class="form-group">
											<label class="form-label">Mobile Phone</label>
											<input type="tel" name="mobile" class="form-control" placeholder="Mobile" value="<?= $user->mobile ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label class="form-label">Address</label>
									<input type="text" name="address" class="form-control" placeholder="Address" value="<?= $user->address ?>">
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<input type="text" name="address2" class="form-control" placeholder="Address Line 2 (Optional)" value="<?= $user->address2 ?>">
								</div>
							</div>
							<div class="col-sm-6 col-md-4">
								<div class="form-group">
									<label class="form-label">City</label>
									<input type="text" name="city" class="form-control" placeholder="City" value="<?= $user->city ?>">
								</div>
							</div>
							<div class="col-sm-6 col-md-3">
								<div class="form-group">
									<label class="form-label">Postal Code</label>
									<input type="number" name="zipcode" class="form-control" placeholder="ZIP Code" value="<?= $user->zipcode ?>">
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-label">Country</label>
									<!-- <select disabled class="form-control custom-select">
										<option value=""></option>
									</select> -->
									<input type="text" name="country" class="form-control" placeholder="Country" value="<?= $user->country ?>">
								</div>
							</div>
							
							<div class="col-md-12">
								<div class="form-group mb-0">
									<label class="form-label">About Me</label>
									<textarea name="about_me" rows="5" class="form-control" placeholder=""><?= $user->about_me ?></textarea>
								</div>
							</div>
						</div>
						
					</div>
					<div class="card-footer pt-3">
						<button type="submit"  name="submit" value="update" class="btn btn-primary pull-right" style="margin-bottom: 10px;"><?= trans("save_changes") ?></button>
					</div>
					<?= form_close(); ?>
				</div>
			</section>
			<!-- /.Section: main -->













