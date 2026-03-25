<div class="" style="border-bottom: 1px solid whitesmoke;margin-bottom: 15px;margin-top: -10px;">
	<div class="row">
		<div class="col-12 col-lg-6">
			<small style="color: #acacac;">ACCOUNT HOLDER:</small><br>
			<h3><a href="<?= base_url() ?>member/<?= $post->owner->id ?>"><?= $post->owner->firstname.' '.$post->owner->lastname ?></a></h3>
		</div>
		<div class="col-6 col-lg-3">
			<small style="color: #acacac;">ACCOUNT NUMBER:</small><br>
			<h3><?php if($post->category_id == 1){ echo 1010000 + $post->id; }else{ echo 2010000 + $post->id; } ?>&nbsp;&nbsp;&nbsp;</h3>
		</div>
		<div class="col-6 col-lg-3 text-right">
			<small style="color: #acacac;">STATEMENT DATE:</small><br>
			<h3><?= date('d M Y') ?></h3>
		</div>
	</div>
</div>
<?php if(date('Y-m-d', strtotime($post->enddate)) > date('Y-m-d')){ ?>
	<div class="row">
		<div class="col">
			<?php 

			$firsttransaction = $this->post_model->getfirsttransactiondate($post->id);
			if(null !== $firsttransaction){
				$startdate = date('Y-m-d', strtotime($firsttransaction));
			}else{
				$startdate = date('Y-m-d', strtotime($post->startdate));
			}

			$now = strtotime(date('Y-m-d H:i:s')); 
			$start = strtotime($startdate);
			$end = strtotime($post->enddate);
			$elpsed = $now - $start; 
			$period = $end - $start;

			$da = round($elpsed / (60 * 60 * 24));
			$ys = round($period / (60 * 60 * 24));

			$percent = 0;
			if($da > 0) $percent = round(($da/$ys) * 100);
			?>
			<h4><small style="color: #acacac;">PERIOD:</small></h4>
			<div class="clearfix">
				<div class="float-left">
					<?= formatted_date($startdate, 'M d, Y'); ?> - <?= formatted_date($post->enddate, 'M d, Y'); ?>
				</div>
				<div class="float-right">
					<small class="text-right"><?= $percent ?>%</small>
				</div>
			</div>
			<div class="progress progress-xs">
				<div class="progress-bar bg-yellow" role="progressbar" style="width: <?= $percent ?>%" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
			<br>
		</div>
	</div>
<?php } ?>
<h4><small style="color: #acacac;">ACCOUNT SUMMARY</small></h4>
<?php $this->load->view('post/_interest', $post);
?>
<div class="hidden-print">
	<?php if(isset($pending[0])){
		echo '<br><h4><small style="color: #acacac;">PENDING TRANSACTIONS</small></h4>';
		$this->load->view('post/_pending', $post);
	} ?>
</div>
<div class="hidden-print">
	<?php if(isset($deleted[0])){
		echo '<br><h4><small style="color: #9e0000;">DELETED TRANSACTIONS</small></h4>';
		$this->load->view('post/_deleted', $post);
	} ?>
</div>
<?php
if(isset($comments[0])){
	echo '<br><h4><small style="color: #acacac;">TRANSACTION HISTORY</small></h4>';
	$this->load->view('post/_transactions', $post); 
} ?>
<style>
	.options-dropdown {
		left: -40px;
	}
</style>
<div class="card-footer hidden-print">
	<div class="row">
		<div class="col">
			&copy; <?= date('Y') ?> Stewards Credit Services
		</div>
		<div class="col text-right text-muted">
			Report Generated on <?= date('d M Y') ?>
		</div>
	</div>
</div>