<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Partial: Categories-->
<div class="widget-title">
	<h4 class="title"><?= html_escape(trans("categories")); ?></h4>
</div>
<div class="col-sm-12 widget-body">
	<div class="row">
		<ul class="widget-list w-category-list">
			<!--List all categories-->
			<?php foreach ($categories as $item): ?>
				<li>
					<a href="<?= generate_category_url($item->parent_slug, $item->slug); ?>"><?= html_escape($item->name); ?></a><span>(<?= get_post_count_by_category($item->id); ?>)</span>
				</li>
				<?php $subcategories = helper_get_subcategories($item->id); ?>
				<?php if (!empty($subcategories)): ?>
					<?php foreach ($subcategories as $subcategory) : ?>
						<li>
							<a href="<?= generate_category_url($subcategory->parent_slug, $subcategory->slug);; ?>"><?= html_escape($subcategory->name); ?></a><span>(<?= get_post_count_by_category($subcategory->id); ?>)</span>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>

			<?php endforeach; ?>
		</ul>
	</div>
</div>
