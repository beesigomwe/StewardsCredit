<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="card">
	<div class="card-header">
		<div class="left">
			<h4 class="card-title">
				ID Image
			</h4>
		</div>
	</div><!-- /.box-header -->
	<div class="card-body">
		<div class="form-group m-0">
			<div class="row">
				<div class="col-sm-12">
					<a class='btn btn-sm bg-purple' data-toggle="modal" data-target="#image_file_manager" data-image-type="main">
						<?= trans('select_image'); ?>
					</a>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<?php if (!empty($post)): ?>
						<img id="selected_image_file" name="" src="<?= base_url() . $post->image_mid; ?>" alt="" class="img-responsive m-t-15"/>
					<?php else: ?>
						<img id="selected_image_file" name="" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="" class="img-responsive"/>
					<?php endif; ?>
					<input type="hidden" name="post_image_id">
				</div>
			</div>
		</div>
	</div>
</div>




