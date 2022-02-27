<!--begin::Modal-->
<div class="modal fade" id="kt_modal_rdv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center w-100">
                <div class="d-flex flex-column bd-highlight mb-4 w-100">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <p class="mx-auto wrap-icon">
                        <i class="far fa-calendar-alt kt-font-primary"></i>
                    </p>
                    <h4 class="modal-title bold" id="exampleModalLabel">Programmer un rendez-vous</h4>
                </div>
            </div>
            <form class="kt-form">
                <div class="modal-body pb-1 pt-4 pl-4 pr-4">

                                        <div class="form-group form-group-last kt-hide">
                        <div class="alert alert-solid-danger" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text errorMsgAjax row">
                                <div class="col-md-12"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group pt-2">
                        <label class="pb-3 label-title">À quel moment de la journée souhaitez-vous être rappelé ?</label>
                        <select class="form-control" name="scheduleRdv" id="scheduleRdv">
                            <option value="Matin">Matin</option>
                            <option value="Après-midi">Après-midi</option>
                            <option value="Pas de préférence">Pas de préférence</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="scheduleAppointmentBtn">Demander un rendez-vous</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!--end::Modal-->