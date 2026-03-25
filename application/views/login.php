<style type="text/css">
  form.card  {
    background: #fffffffb;
    box-shadow: 0 0 10px #00000045;
}
</style>
<div class="page"  style="background-image: url('<?=base_url()?>assets/img/login.jpg');background-size: contain;background-position: 50%;background-repeat: no-repeat;background-color: white;">
  <div class="page-single">
    <div class="container">
      <div class="row">
        <div class="col col-login mx-auto">
          <div class="text-center mb-6">
            <h1 class="logo login">Stewards</h1>
            <!-- <img src="<?=base_url()?>assets/img/logo.png" class="h-6" alt="" style="width: 260px; height: auto!important; "> -->
          </div>
          <div class="text-center">
            <?php $this->load->view('partials/_messages'); ?>
          </div>
          <?= form_open('auth_controller/login_post', ['class'=>'card']); ?>
          <input type="hidden" name="redirect_url" value="<?= lang_base_url(); ?>">
          <div class="card-body p-6">
            <div class="card-title text-center">Login to your account</div>
            <div class="form-group">
              <label class="form-label">Email address</label>
              <input type="text" autocomplete="off" name="username" class="form-control"
              placeholder="<?= trans("username_or_email"); ?>"
              value="<?= html_escape(old('username')); ?>"
              required <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
            </div>
            <div class="form-group">
              <label class="form-label">
                Password
                <?php /* <a href="<?= lang_base_url(); ?>forgot-password" class="float-right small"><?= trans("forgot_password"); ?>?</a> */ ?>
              </label>
              <input type="password" autocomplete="off" name="password" class="form-control"
              placeholder="<?= trans("password"); ?>"
              value="<?= html_escape(old('password')); ?>"
              required <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
            </div>
            <div class="form-group">
              <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" />
                <span class="custom-control-label">Remember me</span>
              </label>
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary btn-block"><?= html_escape(trans("login")); ?></button>
            </div>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>