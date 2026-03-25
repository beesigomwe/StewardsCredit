<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<footer class="footer">
    <div class="container">
      <div class="row align-items-center flex-row-reverse">
        <div class="col-auto ml-lg-auto">
          <div class="row align-items-center">
            <div class="col-auto">
              <ul class="list-inline list-inline-dots mb-0">
                <!-- <li class="list-inline-item"><a href="./docs/index.html">Documentation</a></li> -->
                <!-- <li class="list-inline-item"><a href="./faq.html">FAQ</a></li> -->
              </ul>
            </div>
            <div class="col-auto">
              <a href="mailto:care@dilleva.com" class="btn btn-outline-primary btn-sm">Support</a>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
          Copyright © <?=date('Y')?> <a href="//www.dilleva.com">DillEva</a>. All rights reserved.
        </div>
      </div>
    </div>
</footer>

</div><!-- ./wrapper -->
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url(); ?>assets/admin/js/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>assets/admin/js/adminlte.min.js"></script>
<!-- DataTables js -->
<script src="<?= base_url(); ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- Lazy Load js -->
<script src="<?= base_url(); ?>assets/admin/js/lazysizes.min.js"></script>
<!-- iCheck js -->
<script src="<?= base_url(); ?>assets/vendor/icheck/icheck.min.js"></script>
<!-- Pace -->
<script src="<?= base_url(); ?>assets/admin/plugins/pace/pace.min.js"></script>
<!-- File Manager -->
<script src="<?= base_url(); ?>assets/admin/plugins/file-manager/file-manager-1.2.js"></script>
<script src="<?= base_url(); ?>assets/admin/plugins/tagsinput/jquery.tagsinput.min.js"></script>
<!-- Bootstrap Toggle js -->
<script src="<?= base_url(); ?>assets/admin/js/bootstrap-toggle.min.js"></script>
<!-- Plugins js -->
<script src="<?= base_url(); ?>assets/admin/js/plugins.js"></script>
<!-- Datepicker js -->
<script src="<?= base_url(); ?>assets/vendor/bootstrap-datetimepicker/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<!-- Custom js -->
<script src="<?= base_url(); ?>assets/admin/js/custom.js"></script>

<?php if (isset($lang_search_column)): ?>
	<script>
        var table = $('#cs_datatable_lang').DataTable({
            dom: 'l<"#table_dropdown">frtip',
            "order": [[0, "desc"]],
            "aLengthMenu": [[15, 30, 60, 100], [15, 30, 60, 100, "All"]]
        });
        //insert a label
        $('<label class="table-label"><label/>').text('Language').appendTo('#table_dropdown');

        //insert the select and some options
        $select = $('<select class="form-control input-sm"><select/>').appendTo('#table_dropdown');

        $('<option/>').val('').text('<?= trans("all"); ?>').appendTo($select);
		<?php foreach ($languages as $lang): ?>
        $('<option/>').val('<?= $lang->name; ?>').text('<?= $lang->name; ?>').appendTo($select);
		<?php endforeach; ?>


        $("#table_dropdown select").change(function () {
            table.column(<?= $lang_search_column; ?>).search($(this).val()).draw();
        });
	</script>
<?php endif; ?>

<script src="<?= base_url(); ?>assets/admin/plugins/tinymce/jquery.tinymce.min.js"></script>
<script src="<?= base_url(); ?>assets/admin/plugins/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '.tinyMCE',
        min_height: 500,
        valid_elements: '*[*]',
        relative_urls: false,
        remove_script_host: false,
        language: '<?= $general_settings->text_editor_lang; ?>',
        menubar: 'file edit view insert format tools table help',
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code codesample fullscreen",
            "insertdatetime media table paste imagetools"
        ],
        toolbar: 'code preview | undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | image media link | fullscreen',
        content_css: ['<?= base_url(); ?>assets/admin/plugins/tinymce/editor_content.css'],
    });
    tinymce.DOM.loadCSS('<?= base_url(); ?>assets/admin/plugins/tinymce/editor_ui.css');
</script>

</body>
</html>
