<!--begin::Modal allow access-->
<div class="modal fade" id="kt_modal_am_access" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center w-100">
                <div class="d-flex flex-row bd-highlight w-100">
                    <h5 class="d-flex mb-0 align-items-center">Autoriser l&#039;accès à mon Account Manager</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <form class="kt-form">
                <div class="modal-body pb-1 pt-4 pl-4 pr-4">

                                        <div class="d-flex flex-row align-items-center align-self-center mb-2">
                        <div class="mr-3">
                            <img src="/dashboard/assets/media/team/jd.jpg" class="rounded-circle" style="width: 50px;">
                        </div>
                        <div>
                            <b>Jorys DJEMILI</b><br>
                            Account Manager
                        </div>
                    </div>


                                        <div class="form-group form-group-last kt-hide">
                        <div class="alert alert-solid-danger" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text errorMsgAjax row">
                                <div class="col-md-12"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group pt-2">
                        <label class="pb-3 label-title">Statut :</label>
                        <span id="status_am_access" class="kt-badge kt-badge--unified-secondary kt-badge--inline kt-font-md">...</span>
                        <p><i class="fas fa-info-circle"></i> <i>Votre Account Manager est soumis à une stricte clause de confidentialité.<br />
Accorder l&#039;accès à votre dashboard peut facilier votre formation (onboarding) ou la gestion de cas complexes.<br />
Vous pouvez retirer cette autorisation à tout moment.<br />
</i></p>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary d-none" data-access="1" id="modalAmAccessAllow">Autoriser l&#039;accès</button>
                    <button type="button" class="btn btn-danger d-none" data-access="0" id="modalAmAccessDeny">Bloquer l&#039;accès</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!--end::Modal-->
