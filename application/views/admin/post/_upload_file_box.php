<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="form-group">
	<div class="row">
		<p>Attachments</p>
		<div class="col-sm-12">
			<a class='btn btn-sm bg-purple' data-toggle="modal" data-target="#file_manager">
				Upload Attachments
			</a>
		</div>
		<div class="col-sm-12">
			<div class="post-selected-files">
				<?php
				if (!empty($post)):
					$files = get_post_files($post->id);
					if (!empty($files)):
						foreach ($files as $file): ?>
							<div id="post_selected_file_<?= $file->post_file_id; ?>" class="item">
								<div class="left">
									<i class="fa fa-file"></i>
								</div>
								<div class="center">
									<span><?= $file->file_name; ?></span>
								</div>
								<div class="right">
									<a href="javascript:void(0)" class="btn btn-sm btn-delete-selected-file-database" data-value="<?= $file->post_file_id; ?>"><i class="fa fa-times"></i></a></p>
								</div>
							</div>
						<?php endforeach;
					endif;
				endif; ?>
			</div>

		</div>
	</div>
</div>
