<!-- <div class="row">
    <label class="col-xl-3"></label>
    <div class="col-lg-9 col-xl-6">
        <h3 class="kt-section__title kt-section__title-sm"><?= lang('Core.info_users'); ?>:</h3>
    </div>
</div> -->

<?php if (config('Auth')->requireActivation !== false) { ?>
    <div class="form-group form-group-sm row">
        <label class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Auth.code_activation')); ?> </label>
        <div class="col-lg-9 col-xl-6">
            <span class="switch">
                <label>
                    <input type="checkbox" value="1" name="requireactivation">
                    <span></span>
                </label>
            </span>
            <span class="form-text text-muted"><?= lang('Auth.explain_activation'); ?></span>
        </div>
    </div>
<?php } ?>
<?php  '';//if (!empty($form->id)) { ?> <?=  '';//form_hidden('active', $form->active); ?> <?php '';//} ?>
<?php if (inGroups(1, user()->id)) { ?>
    <div class="form-group row">
        <label for="company_id" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.companies')); ?>* : </label>
        <div class="col-lg-9 col-xl-6">
            <select required name="company_id" class="form-control kt-selectpicker" id="company_id" data-actions-box="true" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>">
                <?php foreach ($form->company as $company) { ?>
                    <option <?= ($company->id == $form->company_id) ? 'selected'  : ''; ?> value="<?= $company->id; ?>"><?= ucfirst($company->raison_social); ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
<?php } else { ?>
    <div class="form-group row" style="display:none">
        <?= form_hidden('company_id', $form->company_id); ?>
    </div>
<?php } ?>
<div class="form-group row">
    <label for="fonction" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.fonction')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('fonction') ? old('fonction') : $form->fonction; ?>" name="fonction" id="fonction">
    </div>
</div>
    <div class="form-group row">
        <label for="username" class="col-xl-3 col-lg-3 col-form-label">
            <span data-skin="dark" data-toggle="tooltip" title="" data-html="true" data-content="" data-original-title="<b>Info</b><br><?= lang('Core.username_form_tooltip_info'); ?>">
                <i class="icon-1x text-dark-50 flaticon2-help"></i> <?= ucfirst(lang('Core.username')); ?>* :
            </span>
        </label>
        <div class="col-lg-9 col-xl-6">
            <input class="form-control" readonly required type="text" value="<?= old('username') ? old('username') : $form->username; ?>" name="username" id="username">

        </div>
    </div>

<div class="form-group row">
    <label for="lastname" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.lastname')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('lastname') ? old('lastname') : $form->lastname; ?>" name="lastname" id="lastname">
    </div>
</div>
<div class="form-group row">
    <label for="firstname" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.firstname')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('firstname') ? old('firstname') : $form->firstname; ?>" name="firstname" id="firstname">
    </div>
</div>

<div class="form-group row">
    <label for="email" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.email')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="email" value="<?= old('email') ? old('email') : $form->email; ?>" name="email" id="email">
    </div>
</div>

<div class="form-group row">
    <label for="phone" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.phone')); ?> : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control phone_international phone_fixe" type="tel" value="<?= old('phone') ? old('phone') : $form->phone; ?>" name="phone" id="phone">
        <div class="invalid-feedback-phone" class="hide"></div>
    </div>
</div>
<div class="form-group row">
    <label for="phone_mobile" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.phone_mobile')); ?> : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control phone_international phone_mobile" type="tel" value="<?= old('phone_mobile') ? old('phone_mobile') : $form->phone_mobile; ?>" name="phone_mobile" id="phone_mobile">
        <div class="invalid-feedback-phone_mobile" class="hide"></div>
    </div>
</div>

<div id="hiddenpassword" class="form-group row">
    <label for="password" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.password')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <div class="input-group">
            <div class="input-group-prepend">
                <button class="btn btn-secondary generer_mot_passe" data-password="<?= generer_mot_de_passe(20); ?>" type="button"><?= lang('Core.generer_mot_de_passe_aleatoire'); ?></button>
            </div>
            <input type="password" class="form-control datapassword" name="password" value="">
            <button class="btn btn-default show-password" data-toggle="tooltip" data-placement="top" data-original-title="<?= lang('Core.voir_element'); ?>" type="button" title="<?= lang('Core.Mask/Unmask password to check content'); ?>"><i class="far fa-eye"></i></button>
            <button data-clipboard="true" data-clipboard-target="#password" data-toggle="tooltip" data-placement="top" data-original-title="<?= lang('Core.copy_element'); ?>" class="btn btn-default dataclipboard" type="button"><i class="la la-copy"></i></button>
            <span type="text" id="password" type="text" style="text-indent:99999999999999999px;position: absolute;color: transparent;z-index:-1"></span>
        </div>
    </div>
</div> 

<div class="row">
        <div class="fl pa2 col-xl-3 col-lg-3 "></div>
        <div class="fl ba b--black-10 h1 col-lg-9 col-xl-6" style="height: 0.25rem">
            <div id="passwordMeter" class="h-100"></div>
        </div>
</div>

<div id="password_confirm-row" class="form-group row">
    <label for="pass_confirm" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.password_confirm')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <div class="input-group">
            <input type="password" class="form-control pass_confirm" name="pass_confirm" value="">
            <button class="btn btn-default show-password" data-toggle="tooltip" data-placement="top" data-original-title="<?= lang('Core.voir_element'); ?>" type="button" title="<?= lang('Core.Mask/Unmask password to check content'); ?>"><i class="far fa-eye"></i>
            </button>
        </div>
    </div>
</div>


<?php if (inGroups(1, user()->id)) { ?>
    <?= $this->include('Themes\backend\metronic\pages\users\__partials\form_group_sp') ?>
<?php } else { ?>
    <?php if (!inGroups(1, user()->id) && $action == 'add') { ?>
        <!-- <?= $this->include('/admin/themes/metronic/controllers/users/__partials/form_group') ?> -->
    <?php } else { ?>
        <?php if (user()->id == $form->id) { ?>
            <?= form_hidden('id_group', explode(',', $id_group)); ?>
        <?php } else { ?>
            <?= $this->include('Themes\backend\metronic\pages\users\__partials\form_group') ?>
        <?php } ?>
    <?php } ?>
<?php } ?>


<?php if (!empty($form->uuid)) { ?> <?= form_hidden('uuid', $form->uuid); ?> <?php } ?>