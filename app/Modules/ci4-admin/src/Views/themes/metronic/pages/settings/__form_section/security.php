 
<div class="form-group row">
    <label for="keyApi" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.key_api')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <div class="input-group">
            <div class="input-group-prepend">
                <button class="btn btn-secondary generer_key_api" type="button"><?= lang('Core.generer_key_api'); ?></button>
            </div>
        <input class="form-control datakey" readonly  required type="text" value="<?= old('keyApi') ? old('keyApi') : service('settings')->get('App.core', 'keyApi') ?>" name="core[keyApi]" id="keyApi">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
    </div>
</div>

<?= $this->section('AdminAfterExtraJs') ?>
<script type="text/javascript">
$(document).on("click", '.generer_key_api', function(e) {

    const packets = {
        token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
    };

    axios.post(current_url + "/genererKeyApi", packets)
    .then( response => {
        $('.datakey').val('');
        $('.datakey').val(response.data.key_api);
    })
    .catch(error => { }); 

});
</script>
<?= $this->endSection() ?>