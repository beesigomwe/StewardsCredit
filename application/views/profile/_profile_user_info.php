<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--user profile info-->
<img src="<?= get_user_avatar($user); ?>" alt="<?= html_escape($user->username); ?>" class="img-profile">
<div class="row-custom user-contact">
    <span class="info"><?= trans("member_since"); ?>&nbsp;<?= helper_date_format($user->created_at); ?></span>
    <?php if ($user->show_email_on_profile): ?>
        <span class="info"><i class="icon-envelope"></i><?= html_escape($user->email); ?></span>
    <?php endif; ?>
</div>
<div class="row-custom">
    <p class="description">
        <?= html_escape($user->about_me); ?>
    </p>
</div>

<div class="row-custom profile-buttons">
    <div class="social">
        <ul>
            <?php if (!empty($user->facebook_url)): ?>
                <li><a href="<?= $user->facebook_url; ?>" target="_blank"><i class="icon-facebook"></i></a></li>
            <?php endif; ?>
            <?php if (!empty($user->twitter_url)): ?>
                <li><a href="<?= $user->twitter_url; ?>" target="_blank"><i class="icon-twitter"></i></a></li>
            <?php endif; ?>
            <?php if (!empty($user->instagram_url)): ?>
                <li><a href="<?= $user->instagram_url; ?>" target="_blank"><i class="icon-instagram"></i></a></li>
            <?php endif; ?>
            <?php if (!empty($user->pinterest_url)): ?>
                <li><a href="<?= $user->pinterest_url; ?>" target="_blank"><i class="icon-pinterest"></i></a></li>
            <?php endif; ?>
            <?php if (!empty($user->linkedin_url)): ?>
                <li><a href="<?= $user->linkedin_url; ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
            <?php endif; ?>
            <?php if (!empty($user->vk_url)): ?>
                <li><a href="<?= $user->vk_url; ?>" target="_blank"><i class="icon-vk"></i></a></li>
            <?php endif; ?>
            <?php if (!empty($user->youtube_url)): ?>
                <li><a href="<?= $user->youtube_url; ?>" target="_blank"><i class="icon-youtube"></i></a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
