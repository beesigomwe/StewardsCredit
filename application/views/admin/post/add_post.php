<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $category = $this->input->get('category');
switch ($category) {
	case '1':
	$category_name = "Investment";
	break;
	case '2':
	$category_name = "Loan";
	break;
	default:
	$category_name = "<span class='accounttype'></span>";
	break;
}
?>
<div class="row">
	<div class="col-sm-12">
		<!-- include message block -->
		<?php $this->load->view('admin/includes/_messages'); ?>
	</div>
</div>

<!-- form start -->
<?= form_open_multipart('post_controller/add_post_post'); ?>
<div class="card">
	<div class="card-header">
		<h3 class="card-title">
			Create New <?= $category_name ?> Account
		</h3>
	</div>
	<div class="card-body">
		<div class="form-post">
			<input type="hidden" name="post_type" value="post">
			<?php
			include ('_form_add_post_left.php');
			include ('_form_add_post_right.php');
			?>
		</div>
	</div>

	<div class="card-footer">
		<?php $this->load->view('admin/includes/_post_publish_box', ['post_type' => $post_type]); ?>
	</div>
</div>
<?= form_close(); ?>


<script>
	$("#amount").keyup(function(event) {

     // skip for arrow keys
     if(event.which >= 37 && event.which <= 40){
     	let val = $(this).val();
     	if(val > 500000000){
     		$(this).val(500000000);
     	}
     	return;
     }

     // format number
     $(this).val(function(index, value) {
     	return value
     	.replace(/\D/g, "")
     	.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
     	;
     });

     var firstValue = Number($('#amount').val().replace(/,/g,''));
     //console.log(firstValue);
 });
</script>