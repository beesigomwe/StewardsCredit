<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<form id="client-details-form">
    <input type="hidden" name="user_id" value="<?= html_escape($post->owner->id) ?>">
    <div class="row">
        <div class="col-auto text-center">
            <div style="height: 100px; width:100px; background-image: url('<?= html_escape($post->owner->avatar ?? '') ?>');background-size: cover;background-color: whitesmoke;border-radius: 5px;">
            </div>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" name="firstname" class="form-control" placeholder="First Name" value="<?= html_escape($post->owner->firstname ?? '') ?>">
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="lastname" class="form-control" placeholder="Last Name" value="<?= html_escape($post->owner->lastname ?? '') ?>">
                    </div>
                </div>
                <div class="col-sm-6 col-md-7">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" value="<?= html_escape($post->owner->email ?? '') ?>">
                    </div>
                </div>
                <div class="col-sm-6 col-md-5">
                    <div class="form-group">
                        <label class="form-label">Mobile Phone</label>
                        <input type="tel" name="mobile" class="form-control" placeholder="Mobile" value="<?= html_escape($post->owner->mobile ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" placeholder="Address" value="<?= html_escape($post->owner->address ?? '') ?>">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <input type="text" name="address2" class="form-control" placeholder="Address Line 2 (Optional)" value="<?= html_escape($post->owner->address2 ?? '') ?>">
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control" placeholder="City" value="<?= html_escape($post->owner->city ?? '') ?>">
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="form-group">
                <label class="form-label">Postal Code</label>
                <input type="text" name="zipcode" class="form-control" placeholder="ZIP Code" value="<?= html_escape($post->owner->zipcode ?? '') ?>">
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label class="form-label">Country</label>
                <input type="text" name="country" class="form-control" placeholder="Country" value="<?= html_escape($post->owner->country ?? '') ?>">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group mb-0">
                <label class="form-label">About</label>
                <textarea name="about_me" rows="3" class="form-control" placeholder="Notes about this client"><?= html_escape($post->owner->about_me ?? '') ?></textarea>
            </div>
        </div>
    </div>
    <div id="client-details-feedback" class="alert mt-2 d-none"></div>
</form>
</div>
<div class="card-footer text-right">
    <button type="button" class="btn btn-primary" id="save-client-details-btn" onclick="saveClientDetails()">
        <i class="fe fe-save"></i> Save Client Details
    </button>
</div>

<script>
function saveClientDetails() {
    var form = document.getElementById('client-details-form');
    var fb   = document.getElementById('client-details-feedback');
    fb.className = 'alert d-none';

    var formData = new FormData(form);
    formData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');

    document.getElementById('save-client-details-btn').disabled = true;

    fetch('<?= base_url('admin_controller/update_client_details_post') ?>', {
        method: 'POST',
        body: formData
    })
    .then(function(r) { return r.json(); })
    .then(function(res) {
        document.getElementById('save-client-details-btn').disabled = false;
        if (res.success) {
            fb.className = 'alert alert-success';
            fb.textContent = res.message || 'Client details saved successfully.';
        } else {
            fb.className = 'alert alert-danger';
            fb.textContent = res.message || 'Save failed.';
        }
    })
    .catch(function(err) {
        document.getElementById('save-client-details-btn').disabled = false;
        fb.className = 'alert alert-danger';
        fb.textContent = 'Network error: ' + err;
    });
}
</script>
