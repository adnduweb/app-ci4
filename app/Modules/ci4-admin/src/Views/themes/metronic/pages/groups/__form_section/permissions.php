<!--begin::Permissions-->
<div class="fv-row">
	<!--begin::Label-->
	<label class="fs-5 fw-bolder form-label mb-2">Role Permissions</label>
	<!--end::Label-->
	<!--begin::Table wrapper-->
	<div class="table-responsive">
		<!--begin::Table-->
		<table class="table align-middle table-row-dashed fs-6 gy-5 ckeck-list-checkbox" id="ckeck-list-checkbox">
			<!--begin::Table body-->
			<tbody class="text-gray-600 fw-bold">

			<tr>
				<td class="text-gray-800"><?= $form->name; ?>
					<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Allows a full access to the system"></i></td>
				<td>
					<!--begin::Checkbox-->
					<label class="form-check form-check-sm form-check-custom form-check-solid me-9">
						<input class="form-check-input" type="checkbox" value="" id="kt_roles_select_all" />
						<span class="form-check-label" for="kt_roles_select_all">Select all</span>
					</label>
					<!--end::Checkbox-->
				</td>
			</tr>


			<?php foreach ($permissions as $permission) { ?>
				<tr class="list" >
					<td>Handle: <?= ucfirst($permission->name); ?> <br /><em><?= $permission->description; ?></em></td>
					<td>
						<?php if (empty($permissionByIdGroupGroup)) { ?>
							<?php if ($form->id === '1') { ?>
								---
							<?php } else { ?>
								<label class="form-check form-check-custom form-check-solid <?= ($form->id === '1') ? 'checkbox-success' : '' ?>">
									<input type="checkbox" name="permission_group[]" class="permission_group form-check-input id_permission_group_<?= $form->id; ?>" value="<?= $form->id; ?>|<?= $permission->id; ?>">
									<span></span>
								</label>
							<?php } ?>
						<?php } else { ?>
							<label class="form-check form-check-custom form-check-solid <?= isset($permissionByIdGroupGroup[$form->id][$permission->id]) ? 'checkbox-success' : '' ?>">
								<input type="checkbox" class="permission_group form-check-input" <?= isset($permissionByIdGroupGroup[$form->id][$permission->id]) ? 'checked="checked"' : '' ?> name="permission_group[]" value="<?= $form->id; ?>|<?= $permission->id; ?>">
								<span></span>
							</label>
						<?php } ?>

					</td>
				</tr>
			<?php }  ?>
		</tbody>
	</table>

	</div>
	<!--end::Table wrapper-->
</div>
<!--end::Permissions-->

<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">


$(document).on("click", ".form-check input.permission_group", function(e) {
    if ($(this).is(':checked')) {
        var $action = 'add';
    } else {
        var $action = 'delete';
    }
    var $val = $(this).val();

    var target = document.querySelector("#kt_content_container .card"); 
    var blockUI = new KTBlockUI(target);

    blockUI.block();

    const packets = {
        value:  $val,
        crud: $action,
        token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
    };

    axios.post("<?= route_to('group-save-permissions') ?>", packets)
    .then( response => {
        toastr.success(response.data.messages.success);
        blockUI.release();
    })
    .catch(error => {
        //console.log("ERROR:: ",error.response.data);
        blockUI.release();
    }); 

});


$(document).on("click", ".form-check input#kt_roles_select_all", function(e) {
    var $valuesss = [];
    if ($(this).is(':checked')) {
        $(".permission_group").prop("checked", true);
        $(".permission_group").attr("checked", 'checked');
        $(".permission_group").each(function(key2, val2) {
            $valuesss.push($(this).val());
        });
        var $action = 'add';
    } else {
        $(".permission_group").each(function() {
            $valuesss.push($(this).val());
            $(".permission_group").prop("checked", false);
        });
        var $action = 'delete';
    }

    var target = document.querySelector("#kt_content_container .card"); 
    var blockUI = new KTBlockUI(target);

    blockUI.block();

    const packets = {
        value:  $valuesss,
        crud: $action,
        token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
    };

    axios.post("<?= route_to('group-save-all-permissions') ?>", packets)
    .then( response => {
        toastr.success(response.data.messages.success);
        blockUI.release();
    })
    .catch(error => {
        //console.log("ERROR:: ",error.response.data);
        blockUI.release();
    }); 

});

</script>

<?= $this->endSection() ?>