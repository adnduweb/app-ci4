<div class="kt-section kt-section--first">
    <div class="kt-section__body">

        <div class="row">
            <label class="col-xl-3"></label>
            <div class="col-lg-9 col-xl-6">
                <h3 class="kt-section__title kt-section__title-sm"><?= lang('Core.reglages_notifications'); ?>:</h3>
            </div>
        </div>
        <div class="form-group form-group-sm row">
            <label class="col-xl-3 col-lg-3 col-form-label"><?= lang('Core.notification_email'); ?></label>
            <div class="col-lg-9 col-xl-6">
                <span class="switch">
                    <label>
                        <?php if (user()->id == $form->id) { ?>
                            <input type="checkbox" <?= (service('settings')->setting_notification_email == '1') ? 'checked="checked"' : ''; ?> name="setting_notification_email" value="1">
                        <?php } else { ?>
                            <input type="checkbox" disabled name="setting_notification_email" value="1">
                        <?php } ?>
                        <span></span>
                    </label>
                </span>
            </div>
        </div>
        <div class="form-group form-group-sm row">
            <label class="col-xl-3 col-lg-3 col-form-label"><?= lang('Core.notification_sms'); ?></label>
            <div class="col-lg-9 col-xl-6">
                <span class="switch">
                    <label>
                        <?php if (user()->id == $form->id) { ?>
                            <input type="checkbox" <?= (service('settings')->setting_notification_sms == '1') ? 'checked="checked"' : ''; ?> name="setting_notification_sms" value="1">
                        <?php } else { ?>
                            <input type="checkbox" disabled name="setting_notification_sms" value="1">
                        <?php } ?>
                        <span></span>
                    </label>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="separator separator-solid separator-border-1 mt-5 mb-5"></div>
<div class="kt-section kt-section--first">
    <div class="kt-section__body">
        <div class="row">
            <label class="col-xl-3"></label>
            <div class="col-lg-9 col-xl-6">
                <h3 class="kt-section__title kt-section__title-sm"><?= lang('Core.activity_from_account'); ?>:</h3>
            </div>
        </div>

        <div class="form-group form-group-sm form-group-last row">
            <label class="col-xl-3 col-lg-3 col-form-label"><?= lang('Core.status_account'); ?></label>
            <div class="col-lg-9 col-xl-6">
            <select required name="status" class="form-control kt-selectpicker" id="status">
                <?php foreach (config('Auth')->status as $k => $v) { ?>
                    <option <?= ($form->status == $k) ? 'selected' : ''; ?> value="<?= $k; ?>" ><?= lang('Auth.' . $v); ?></option>
                <?php } ?>
            </select>
            </div>
        </div>

        <div class="form-group form-group-sm row">
            <label class="col-xl-3 col-lg-3 col-form-label"><?= lang('Core.connexion_unique'); ?></label>
            <div class="col-lg-9 col-xl-6">
                <span class="switch">
                    <label>
                        <?php if (user()->id == $form->id) { ?>
                            <input type="checkbox" <?= (service('settings')->setting_connexion_unique == '1') ? 'checked="checked"' : ''; ?> name="setting_connexion_unique" value="1">
                        <?php } else { ?>
                            <input type="checkbox" disabled name="setting_connexion_unique" value="1">
                        <?php } ?>
                        <span></span>
                    </label>
                </span>
            </div>
        </div>
        <div class="form-group form-group-sm form-group-last row">
            <label class="col-xl-3 col-lg-3 col-form-label">
                <span data-skin="dark" data-toggle="tooltip" title="" data-html="true" data-content="" data-original-title="<b>Info</b><br><?= lang('Core.force_pass_reset_form_tooltip_info'); ?>">
                    <i class="flaticon2-help"></i>
                    <?= lang('Core.force_chgt_password'); ?>
                </span>
            </label>
            <div class="col-lg-9 col-xl-6">
                <span class="switch">
                    <label>
                        <input type="checkbox" <?= ($form->force_pass_reset == '1') ? 'checked="checked"' : ''; ?> name="force_pass_reset" value="1">
                        <span></span>
                    </label>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="separator separator-solid separator-border-1 mt-5 mb-5"></div>
<div class="kt-section kt-section--first">
    <div class="kt-section__body">
        <div class="row">
            <label class="col-xl-3"></label>
            <div class="col-lg-9 col-xl-6">
                <h3 class="kt-section__title kt-section__title-sm"><?= lang('Core.browser_sessions'); ?></h3>
                <p><?= lang('Core.If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.'); ?></p>
                    <?= $this->include('Themes\backend\metronic\pages\users\__partials\browser_session') ?>
            </div>
        </div>

    </div>
</div>
