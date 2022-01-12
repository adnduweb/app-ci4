<!-- <div class="row">
    <label class="col-xl-3"></label>
    <div class="col-lg-9 col-xl-6">
        <h3 class="kt-section__title kt-section__title-sm"><?= ucfirst(lang('Core.info_security')); ?>:</h3>
    </div>
</div> -->
 
<div class="form-group row">
    <label for="keyApi" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.key_api')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <div class="input-group">
            <div class="input-group-prepend">
                <button class="btn btn-secondary generer_key_api" type="button"><?= lang('Core.generer_key_api'); ?></button>
            </div>
        <input class="form-control datakey" readonly  required type="text" value="<?= old('keyApi') ? old('keyApi') : $form->keyApi; ?>" name="global[keyApi]" id="keyApi">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
    </div>
</div>

<?= $this->section('AdminAfterExtraJs') ?>
<script type="text/javascript">
$(document).on("click", '.generer_key_api', function(e) {
    $.post(baseController + "/genererKeyApi", {
            [crsftoken]: $('meta[name="csrf-token"]').attr('content'),
        },
        function(response, status) {

            if (response.error == false) {
                $('.datakey').val('');
                $('.datakey').val(response.success.key_api);
                $('meta[name="csrf-token"]').attr('content', response._token);
                $('input[name="' + crsftoken + '"]').attr('value', response._token);
            }
        });
});
</script>
<?= $this->endSection() ?>