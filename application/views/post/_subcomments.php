<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $subcomments = get_subcomments($parent_comment->id); ?>
<?php if (!empty($subcomments)): ?>
	<div class="row-custom">
		<div class="comments">
			<ul class="comment-list">
				<?php foreach ($subcomments as $subcomment):
					$subcomment_user = null;
					if (!empty($subcomment->user_id)) {
						$subcomment_user = get_user($subcomment->user_id);
					} ?>
					<li>
						<div class="left">
							<?php if (!empty($subcomment_user)): ?>
								<a href="<?= generate_profile_url($subcomment_user); ?>">
									<img src="<?= get_user_avatar($subcomment_user); ?>" alt="<?= html_escape($subcomment_user->username); ?>">
								</a>
							<?php else: ?>
								<img src="<?= get_user_avatar_by_id($subcomment->user_id); ?>" alt="<?= html_escape($subcomment->name); ?>">
							<?php endif; ?>
						</div>
						<div class="right">
							<div class="row-custom">
								<?php if (!empty($subcomment_user)):  ?>
									<a href="<?= generate_profile_url($subcomment_user); ?>">
										<span class="username"><?= html_escape($subcomment_user->username); ?></span>
									</a>
								<?php else: ?>
									<span class="username"><?= html_escape($subcomment->name); ?></span>
								<?php endif; ?>
							</div>
							<div class="row-custom comment">
								<?= html_escape($subcomment->comment); ?>
							</div>
							<div class="row-custom">
								<span class="date"><?= time_ago($subcomment->created_at); ?></span>
								<?php if (auth_check()):
									if ($subcomment->user_id == user()->id || user()->role == "admin"): ?>
										<a href="javascript:void(0)" class="btn-delete-comment" onclick="delete_comment('<?= $subcomment->id; ?>','<?= $subcomment->post_id; ?>','<?= trans("confirm_comment"); ?>');"><?= trans("delete"); ?></a>
									<?php endif;
								endif; ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
<?php endif; ?>
