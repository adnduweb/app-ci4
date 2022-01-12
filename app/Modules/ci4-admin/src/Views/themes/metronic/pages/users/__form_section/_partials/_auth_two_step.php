<!--begin::Card-->
<div class="card pt-4 mb-6 mb-xl-9 card_two_factors">

    <!--begin::Spinner-->
    <span class="spinner_card spinner_card_1 spinner-warning spinner-lg position-absolute lh-0 d-none" data-kt-search-element="spinner">
        <span class="spinner-border h-45px w-45px align-middle text-warning"></span>
    </span>
    <!--end::Spinner-->
    
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title flex-column">
            <h2 class="mb-1">Two Step Authentication</h2>
            <div class="fs-6 fw-bold text-muted">Keep your account extra secure with a second authentication step.</div>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Add-->
            <button type="button" class="btn btn-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <?= service('theme')->getSVG('duotune/technology/teh004.svg', "svg-icon svg-icon-3"); ?>
                Add Authentication Step
            </button>
            <!--begin::Menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-6 w-200px py-4" data-kt-menu="true">
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_add_auth_app">Application Mobile</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_add_one_time_sms">Par SMS</a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_add_one_time_email">Par mail</a>
                </div>
                <!--end::Menu item-->
            </div>
            <!--end::Menu-->
            <!--end::Add-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <div  id="kt_auth_two_step_list">
        <?= view('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_auth_two_step_list', ['form' => $form]) ?>
    </div>
   
</div>
<!--end::Card-->

<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__modals\_auth_two_factor_1') ?>
<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__modals\_auth_two_factor_2') ?>
<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__modals\_auth_two_factor_3') ?>


<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">

    "use strict";

    // Class definition
    var KTUsersManageTwaFactor = function () {

        var spinner = document.querySelector('.card_two_factors [data-kt-search-element="spinner"]');

        // Delete two step authentication handler
        const initDeleteTwoStep = () => {
            const deleteButton = document.getElementById('kt_users_delete_two_step');
            var target = document.querySelector(".card_two_factors.card");
            var blockUI = new KTBlockUI(target);

            if(deleteButton == null) 
            return false;

            deleteButton.addEventListener('click', e => {
                e.preventDefault();

                Swal.fire({
                    text: "Are you sure you would like remove this two-step authentication?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, remove it!",
                    cancelButtonText: "No, return",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light"
                    }
                }).then(function (result) {
                    if (result.value) {

                        blockUI.block();   
                        
                        const packets = {
                            time: $.now(),
                            user_id: "<?= $form->uuid; ?>"
                        };
 
                        axios.delete("<?= route_to('user-delete-2fa') ?>",  { data: packets})
                        .then( response => {
                            deleteButton.removeAttribute('data-kt-indicator'); // remove the indicator
                            toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                            $('#kt_auth_two_step_list').html(response.data.display_auth_two_step_list); // display the user
                            deleteButton.disabled = false; // hide the submit
                            blockUI.release();
                            modal.hide(); // hide the modal
                        })
                        .catch(error => {blockUI.release(); deleteButton.disabled = false;});   
                    } 
                });
            })
        }
        return {
        // Public functions
        init: function () {
            initDeleteTwoStep();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersManageTwaFactor.init();
});

</script>

<?= $this->endSection() ?>