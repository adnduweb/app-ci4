<!--begin:::Tab pane-->
<div class="tab-pane fade" id="kt_user_view_overview_permissions_tab" role="tabpanel">
   <!--begin::Permissions-->
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">Role Permissions</div>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
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
                        <tr class="list list_<?= $permission->id; ?>" >
                            <td>Handle: <?= ucfirst($permission->name); ?> <br /><em><?= $permission->description; ?></em></td>



                            <td>
                                <?php if (empty($permissionByIdGroupGroup[$form->auth_groups_users[0]->group_id])) { ?>
                                    <?php if ($form->auth_groups_users[0]->group_id == '1') { ?>
                                        ---
                                    <?php } else { ?>
                                        <label class="form-check form-check-custom form-check-solid <?= ($form->auth_groups_users[0]->group_id == '1') ? 'checkbox-success' : '' ?>">
                                            <input type="checkbox" name="permission_group[]" class="permission_group form-check-input id_permission_group_<?= $form->auth_groups_users[0]->group_id; ?>" value="<?= $form->id; ?>|<?= $permission->id; ?>">
                                            <span></span>
                                        </label>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php if (in_array($permission->id, $permissionByIdGroupGroup[$form->auth_groups_users[0]->group_id])) { ?>
                                        <label class="form-check form-check-custom form-check-solid checkbox-disabled <?= isset($permissionByIdGroupGroup[$form->auth_groups_users[0]->group_id][$permission->id]) ? 'checkbox-success' : '' ?>">
                                            <input disabled="disabled" type="checkbox" class="permission_group form-check-input " <?= isset($permissionByIdGroupGroup[$form->auth_groups_users[0]->group_id][$permission->id]) ? 'checked="checked"' : '' ?> name="permission_group[]" value="<?= $form->id; ?>|<?= $permission->id; ?>">
                                            <span></span>
                                        </label>
                                    <?php } else { ?>
                                        <?php if (!empty($permissionByIdGroupGroupUser[$form->id]) && in_array($permission->id, $permissionByIdGroupGroupUser[$form->id])) { ?>
                                            <label class="form-check form-check-custom form-check-solid <?= isset($permissionByIdGroupGroupUser[$form->id][$permission->id]) ? 'checkbox-success' : '' ?>">
                                                <input type="checkbox" class="permission_group form-check-input " <?= isset($permissionByIdGroupGroupUser[$form->id][$permission->id]) ? 'checked="checked"' : '' ?> name="permission_group[]" value="<?= $form->id; ?>|<?= $permission->id; ?>">
                                                <span></span>
                                            </label>
                                        <?php } else { ?>
                                            <label class="form-check form-check-custom form-check-solid <?= isset($permissionByIdGroupGroup[$form->auth_groups_users[0]->group_id][$permission->id]) ? 'checkbox-success' : '' ?>">
                                                <input type="checkbox" class="permission_group form-check-input " <?= isset($permissionByIdGroupGroup[$form->auth_groups_users[0]->group_id][$permission->id]) ? 'checked="checked"' : '' ?> name="permission_group[]" value="<?= $form->id; ?>|<?= $permission->id; ?>">
                                                <span></span>
                                            </label>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>

                            </td>
                        </tr>
                    <?php }  ?>
                </tbody>
            </table>
        </div>
	</div>
	<!--end::Table wrapper-->
</div>
<!--end::Permissions-->
</div>
<!--end:::Tab pane-->

<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">

"use strict";

// Class definition
var KTUPermissionsUsersUpdate = function () {

    const element = document.getElementById('kt_user_view_overview_permissions_tab');
    const check = element.querySelector('#ckeck-list-checkbox');
    const inputCheck = element.querySelectorAll('.form-check input.permission_group');

    // Init add schedule modal
    var initPermissionsUserUpdateOnly = () => {

        inputCheck.forEach(d => {

            d.addEventListener('click', function (e) {

                var target = document.querySelector(".card_1.card");
                var blockUI = new KTBlockUI(target);

                if ($(this).is(':checked')) {
                    var $action = 'add';
                } else {
                    var $action = 'delete';
                }
                var $val = $(this).val();

                const packets = {
                    value:  $val,
                    crud: $action
                };


                axios.post("<?= route_to('group-save-permissions-users') ?>", packets)
                .then( response => {
                    toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                    blockUI.release();
                    
                })
                .catch(error => {blockUI.release(); }); 
            });

        });
    }

return {
        // Public functions
        init: function () {
            initPermissionsUserUpdateOnly();
        }
    };

}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUPermissionsUsersUpdate.init();
});

</script>

<?= $this->endSection() ?>
