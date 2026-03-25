<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
	.card {
		transition-duration: 500ms;
	}
	.card:hover {
		box-shadow: 0 10px 20px #0000005c;
		transition-duration: 500ms;
	}
</style>
<!-- Small boxes (Stat box) -->
<div class="row row-cards">

	<div class="col-12 col-sm-12 col-md-6 col-lg-4">
		<a href="<?= admin_url(); ?>posts?show=15&category=1">
			<div class="card">
				<div class="card-body p-3 text-center" style="background: url('<?=base_url()?>assets/img/investment.jpg'); background-size: contain; background-position: 100% 36%; text-align: left!important; padding-left: 20px!important;background-repeat: no-repeat;">
					<div class="h1 my-8">Investors</div>
				</div>
			</div>
		</a>
	</div>

	<div class="col-12 col-sm-12 col-md-6 col-lg-4">
		<a href="<?= admin_url(); ?>posts?show=15&category=2">
			<div class="card">
				<div class="card-body p-3 text-center" style="background: url('<?=base_url()?>assets/img/loans.jpg'); background-size: contain;background-position: 100% bottom;text-align: left!important;padding-left: 20px!important;background-repeat: no-repeat;">
					<div class="h1 my-8">Loans</div>
				</div>
			</div>
		</a>
	</div>

	<?php if (is_admin()): ?>
		<div class="col-12 col-sm-12 col-md-6 col-lg-4">
			<a href="<?= admin_url(); ?>users">
				<div class="card">
					<div class="card-body p-3 text-center" style="background: url('<?=base_url()?>assets/img/administration.jpg'); background-size: contain; background-position: 100% 36%; text-align: left!important; padding-left: 20px!important;background-repeat: no-repeat;">
						<div class="h1 my-8">Administration</div>
					</div>
				</div>
			</a>
		</div>

		<div class="col-12 col-sm-12 col-md-6 col-lg-4">
			<a href="<?= admin_url(); ?>../backoffice">
				<div class="card">
					<div class="card-body p-3 text-center" style="background: url('<?=base_url()?>assets/img/administration.jpg'); background-size: contain; background-position: 100% 36%; text-align: left!important; padding-left: 20px!important;background-repeat: no-repeat;">
						<div class="h1 my-8">Back Office</div>
					</div>
				</div>
			</a>
		</div>
	<?php endif; ?>
</div>
