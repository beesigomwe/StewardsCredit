<div class="row">
	<div class="col-auto text-center">
		<div style="height: 100px; width:100px; background-image: url('<?= $post->owner->avatar ?>');background-size: cover;background-color: whitesmoke;border-radius: 5px;">
		</div>
		<div class="form-group" style="margin-top: 8px;">
			<button  disabled class="form-control btn btn-default hidden-print">Upload Photo</button>
		</div>
	</div>
	<div class="col">
		<div class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-group">
					<label class="form-label">First Name</label>
					<input type="text" disabled class="form-control" placeholder="Company" value="<?= $post->owner->firstname ?>">
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-group">
					<label class="form-label">Last Name</label>
					<input type="text" disabled class="form-control" placeholder="Last Name" value="<?= $post->owner->lastname ?>">
				</div>
			</div>
			<div class="col-sm-6 col-md-7">
				<div class="form-group">
					<label class="form-label">Email address</label>
					<input type="email" disabled class="form-control" placeholder="Email" value="<?= $post->owner->email ?>">
				</div>
			</div>
			<div class="col-sm-6 col-md-5">
				<div class="form-group">
					<label class="form-label">Mobile Phone</label>
					<input type="tel" disabled class="form-control" placeholder="Mobile" value="<?= $post->owner->mobile ?>">
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="form-label">Address</label>
			<input type="text" disabled class="form-control" placeholder="Address" value="<?= $post->owner->address ?>">
		</div>
	</div>

	<div class="col-md-12">
		<div class="form-group">
			<input type="text" disabled class="form-control" placeholder="Address Line 2 (Optional)" value="<?= $post->owner->address2 ?>">
		</div>
	</div>
	<div class="col-sm-6 col-md-4">
		<div class="form-group">
			<label class="form-label">City</label>
			<input type="text" disabled class="form-control" placeholder="City" value="<?= $post->owner->city ?>">
		</div>
	</div>
	<div class="col-sm-6 col-md-3">
		<div class="form-group">
			<label class="form-label">Postal Code</label>
			<input type="number" disabled class="form-control" placeholder="ZIP Code" value="<?= $post->owner->zipcode ?>">
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<label class="form-label">Country</label>
			<!-- <select disabled class="form-control custom-select">
				<option value=""></option>
			</select> -->
			<input type="text" disabled class="form-control" placeholder="Country" value="<?= $post->owner->country ?>">
		</div>
	</div>

	<div class="col-md-12">
		<div class="form-group mb-0">
			<label class="form-label">About Me</label>
			<textarea disabled rows="5" class="form-control" placeholder=""><?= $post->owner->about_me ?></textarea>
		</div>
	</div>
</div>
</div>
<div class="card-footer text-right">
	<a href="<?= base_url() ?>user/<?= $post->owner->id ?>"><button type="button" class="btn btn-primary">Edit Client Details</button></a>
