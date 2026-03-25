<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $ed_langs = array();
$ed_langs[] = array("short" => "ar", "name" => "Arabic");
$ed_langs[] = array("short" => "hy", "name" => "Armenian");
$ed_langs[] = array("short" => "az", "name" => "Azerbaijani");
$ed_langs[] = array("short" => "eu", "name" => "Basque");
$ed_langs[] = array("short" => "be", "name" => "Belarusian");
$ed_langs[] = array("short" => "bn_BD", "name" => "Bengali (Bangladesh)");
$ed_langs[] = array("short" => "bs", "name" => "Bosnian");
$ed_langs[] = array("short" => "bg_BG", "name" => "Bulgarian");
$ed_langs[] = array("short" => "ca", "name" => "Catalan");
$ed_langs[] = array("short" => "zh_CN", "name" => "Chinese (China)");
$ed_langs[] = array("short" => "zh_TW", "name" => "Chinese (Taiwan)");
$ed_langs[] = array("short" => "hr", "name" => "Croatian");
$ed_langs[] = array("short" => "cs", "name" => "Czech");
$ed_langs[] = array("short" => "da", "name" => "Danish");
$ed_langs[] = array("short" => "dv", "name" => "Divehi");
$ed_langs[] = array("short" => "nl", "name" => "Dutch");
$ed_langs[] = array("short" => "en", "name" => "English");
$ed_langs[] = array("short" => "et", "name" => "Estonian");
$ed_langs[] = array("short" => "fo", "name" => "Faroese");
$ed_langs[] = array("short" => "fi", "name" => "Finnish");
$ed_langs[] = array("short" => "fr_FR", "name" => "French");
$ed_langs[] = array("short" => "gd", "name" => "Gaelic, Scottish");
$ed_langs[] = array("short" => "gl", "name" => "Galician");
$ed_langs[] = array("short" => "ka_GE", "name" => "Georgian");
$ed_langs[] = array("short" => "de", "name" => "German");
$ed_langs[] = array("short" => "el", "name" => "Greek");
$ed_langs[] = array("short" => "he", "name" => "Hebrew");
$ed_langs[] = array("short" => "hi_IN", "name" => "Hindi");
$ed_langs[] = array("short" => "hu_HU", "name" => "Hungarian");
$ed_langs[] = array("short" => "is_IS", "name" => "Icelandic");
$ed_langs[] = array("short" => "id", "name" => "Indonesian");
$ed_langs[] = array("short" => "it", "name" => "Italian");
$ed_langs[] = array("short" => "ja", "name" => "Japanese");
$ed_langs[] = array("short" => "kab", "name" => "Kabyle");
$ed_langs[] = array("short" => "kk", "name" => "Kazakh");
$ed_langs[] = array("short" => "km_KH", "name" => "Khmer");
$ed_langs[] = array("short" => "ko_KR", "name" => "Korean");
$ed_langs[] = array("short" => "ku", "name" => "Kurdish");
$ed_langs[] = array("short" => "lv", "name" => "Latvian");
$ed_langs[] = array("short" => "lt", "name" => "Lithuanian");
$ed_langs[] = array("short" => "lb", "name" => "Luxembourgish");
$ed_langs[] = array("short" => "ml", "name" => "Malayalam");
$ed_langs[] = array("short" => "mn", "name" => "Mongolian");
$ed_langs[] = array("short" => "nb_NO", "name" => "Norwegian Bokmål (Norway)");
$ed_langs[] = array("short" => "fa", "name" => "Persian");
$ed_langs[] = array("short" => "pl", "name" => "Polish");
$ed_langs[] = array("short" => "pt_BR", "name" => "Portuguese (Brazil)");
$ed_langs[] = array("short" => "pt_PT", "name" => "Portuguese (Portugal)");
$ed_langs[] = array("short" => "ro", "name" => "Romanian");
$ed_langs[] = array("short" => "ru", "name" => "Russian");
$ed_langs[] = array("short" => "sr", "name" => "Serbian");
$ed_langs[] = array("short" => "si_LK", "name" => "Sinhala (Sri Lanka)");
$ed_langs[] = array("short" => "sk", "name" => "Slovak");
$ed_langs[] = array("short" => "sl_SI", "name" => "Slovenian (Slovenia)");
$ed_langs[] = array("short" => "es", "name" => "Spanish");
$ed_langs[] = array("short" => "es_MX", "name" => "Spanish (Mexico)");
$ed_langs[] = array("short" => "sv_SE", "name" => "Swedish (Sweden)");
$ed_langs[] = array("short" => "tg", "name" => "Tajik");
$ed_langs[] = array("short" => "ta", "name" => "Tamil");
$ed_langs[] = array("short" => "tt", "name" => "Tatar");
$ed_langs[] = array("short" => "th_TH", "name" => "Thai");
$ed_langs[] = array("short" => "tr", "name" => "Turkish");
$ed_langs[] = array("short" => "ug", "name" => "Uighur");
$ed_langs[] = array("short" => "uk", "name" => "Ukrainian");
$ed_langs[] = array("short" => "vi", "name" => "Vietnamese");
$ed_langs[] = array("short" => "cy", "name" => "Welsh"); ?>

<div class="row">
	<div class="col-lg-5 col-md-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?= trans("default_language"); ?></h3>
			</div>
			<!-- /.box-header -->

			<!-- form start -->
			<?= form_open('language_controller/set_language_post'); ?>

			<div class="card-body">
				<!-- include message block -->
				<?php if (!empty($this->session->flashdata('mes_set_language'))):
					$this->load->view('admin/includes/_messages_form');
				endif; ?>

				<div class="form-group">
					<label><?= trans("site_language"); ?></label>
					<select name="site_lang" class="form-control">
						<?php foreach ($languages as $language): ?>
							<option value="<?= $language->id; ?>" <?= ($site_lang->id == $language->id) ? 'selected' : ''; ?>><?= $language->name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label><?= trans('text_editor_language'); ?></label>
					<select name="text_editor_lang" class="form-control" required>
						<?php foreach ($ed_langs as $ed_lang): ?>
							<option value="<?= $ed_lang['short']; ?>" <?= ($ed_lang['short'] == $general_settings->text_editor_lang) ? 'selected' : ''; ?>><?= $ed_lang['name']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>

			</div>

			<!-- /.box-body -->
			<div class="card-footer">
				<button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
			</div>
			<!-- /.box-footer -->
			<?= form_close(); ?><!-- form end -->
		</div>

		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?= trans("add_language"); ?></h3>
			</div>
			<!-- /.box-header -->

			<!-- form start -->
			<?= form_open('language_controller/add_language_post'); ?>

			<div class="card-body">
				<!-- include message block -->
				<?php if (empty($this->session->flashdata('mes_set_language'))):
					$this->load->view('admin/includes/_messages_form');
				endif; ?>

				<div class="form-group">
					<label><?= trans("language_name"); ?></label>
					<input type="text" class="form-control" name="name" placeholder="<?= trans("language_name"); ?>"
						   value="<?= old('name'); ?>" maxlength="200" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
					<small>(Ex: English)</small>
				</div>

				<div class="form-group">
					<label class="control-label"><?= trans("short_form"); ?> </label>
					<input type="text" class="form-control" name="short_form" placeholder="<?= trans("short_form"); ?>"
						   value="<?= old('short_form'); ?>" maxlength="200" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
					<small>(Ex: en)</small>
				</div>

				<div class="form-group">
					<label class="control-label"><?= trans("language_code"); ?> </label>
					<input type="text" class="form-control" name="language_code" placeholder="<?= trans("language_code"); ?>"
						   value="<?= old('language_code'); ?>" maxlength="200" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
					<small>(Ex: en-US)</small>
				</div>

				<div class="form-group">
					<label><?= trans('order'); ?></label>
					<input type="number" class="form-control" name="language_order" placeholder="<?= trans('order'); ?>" value="1" min="1" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-3 col-xs-12">
							<label><?= trans('text_direction'); ?></label>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12 col-option">
							<input type="radio" id="rb_type_1" name="text_direction" value="ltr" class="square-purple" checked>
							<label for="rb_type_1" class="cursor-pointer"><?= trans('left_to_right'); ?></label>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12 col-option">
							<input type="radio" id="rb_type_2" name="text_direction" value="rtl" class="square-purple">
							<label for="rb_type_2" class="cursor-pointer"><?= trans('right_to_left'); ?></label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-3 col-xs-12">
							<label><?= trans('status'); ?></label>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12 col-option">
							<input type="radio" id="status1" name="status" value="1" class="square-purple" checked>
							<label for="status1" class="cursor-pointer"><?= trans('active'); ?></label>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12 col-option">
							<input type="radio" id="status2" name="status" value="0" class="square-purple">
							<label for="status2" class="cursor-pointer"><?= trans('inactive'); ?></label>
						</div>
					</div>
				</div>
			</div>

			<!-- /.box-body -->
			<div class="card-footer">
				<button type="submit" class="btn btn-primary pull-right"><?= trans('add_language'); ?></button>
			</div>
			<!-- /.box-footer -->
			<?= form_close(); ?><!-- form end -->
		</div>
		<!-- /.box -->
	</div>


	<div class="col-lg-7 col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="pull-left">
					<h3 class="card-title"><?= trans('languages'); ?></h3>
				</div>
			</div><!-- /.box-header -->

			<div class="card-body">
				<div class="row">
					<!-- include message block -->
					<div class="col-sm-12">
						<?php $this->load->view('admin/includes/_messages'); ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive">
							<table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid"
								   aria-describedby="example1_info">
								<thead>
								<tr role="row">
									<th width="20"><?= trans('id'); ?></th>
									<th><?= trans('language_name'); ?></th>
									<th><?= trans('folder_name'); ?></th>
									<th></th>
									<th class="max-width-120"><?= trans('options'); ?></th>
								</tr>
								</thead>
								<tbody>

								<?php foreach ($languages as $item): ?>
									<tr>
										<td><?= html_escape($item->id); ?></td>
										<td><?= html_escape($item->name); ?>&nbsp;
											<?php if ($item->status == 1): ?>
												<label class="label label-success pull-right lbl-lang-status"><?= trans('active'); ?></label>
											<?php else: ?>
												<label class="label label-danger pull-right lbl-lang-status"><?= trans('inactive'); ?></label>
											<?php endif; ?>
										</td>
										<td><?= html_escape($item->folder_name); ?></td>
										<td><a href="<?= admin_url(); ?>update-phrases/<?= $item->id; ?>?page=1" class="btn btn-sm btn-success">
												<i class="fa fa-exchange"></i>&nbsp;<?= trans('edit_translations'); ?>
											</a>
										</td>

										<td>
											<div class="dropdown">
												<button class="btn bg-purple dropdown-toggle btn-select-option"
														type="button"
														data-toggle="dropdown"><?= trans('select_option'); ?>
													<span class="caret"></span>
												</button>
												<ul class="dropdown-menu options-dropdown">
													<li>
														<a href="<?= admin_url(); ?>update-language/<?= html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
													</li>
													<li>
														<a href="javascript:void(0)" onclick="delete_item('language_controller/delete_language_post','<?= $item->id; ?>','<?= trans("confirm_language"); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
													</li>
												</ul>
											</div>
										</td>
									</tr>

								<?php endforeach; ?>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div><!-- /.box-body -->
		</div>
	</div>
</div>
