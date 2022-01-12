<div class="form-group row">
    <label for="id_group" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.groupes')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <select required name="id_group[]" class="form-control kt-selectpicker" multiple id="id_group">
            <?php foreach ($groups as $group) { ?>
                <?php if ($group->id != 1) { ?>
                    <?php if ($action == 'edit') { ?>
                        <option <?= inGroups($group->id, $form->id) ? 'selected' : ''; ?> value="<?= $group->id; ?>"><?= ucfirst($group->name); ?></option>
                    <?php } else { ?>
                        <option value="<?= $group->id; ?>"><?= ucfirst($group->name); ?></option>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
</div>