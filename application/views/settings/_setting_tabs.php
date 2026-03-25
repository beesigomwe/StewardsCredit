<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="profile-tabs">
    <ul class="nav">
        <li class="nav-item <?= ($active_tab == 'update_profile') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= lang_base_url(); ?>settings">
                <span><?= trans("update_profile"); ?></span>
            </a>
        </li>
        <li class="nav-item <?= ($active_tab == 'social_accounts') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= lang_base_url(); ?>settings/social-accounts">
                <span><?= trans("social_accounts"); ?></span>
            </a>
        </li>
        <li class="nav-item <?= ($active_tab == 'change_password') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= lang_base_url(); ?>settings/change-password">
                <span><?= trans("change_password"); ?></span>
            </a>
        </li>
    </ul>
</div>