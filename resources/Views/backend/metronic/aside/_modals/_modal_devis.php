<!--begin::Modal-->
<div class="modal fade" id="kt_modal_devis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center w-100">
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <?= service('theme')->getSVG('duotone/Navigation/Close.svg', "svg-icon svg-icon-1"); ?>
                    </div>
                    <!--end::Close-->
                <div class="d-flex flex-column bd-highlight mb-4 w-100">
                   
                    <p class="mx-auto wrap-icon">
                        <i class="far fa-file-alt kt-font-primary"></i>
                    </p>
                    <h4 class="modal-title bold" id="exampleModalLabel">Demander un devis</h4>
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
                        <label class="pb-3 label-title">Votre devis concerne quel(s) produit(s) ?</label>

                        <div class="form-group">
                            <div class="checkbox-inline d-flex form">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input  name="devis[]" class="form-check-input" type="checkbox" data-kt-check="true" value="Security" /> Security
                                </div>
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input  name="devis[]" class="form-check-input" type="checkbox" data-kt-check="true" value="Monitoring" /> Monitoring
                                </div>
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input  name="devis[]" class="form-check-input" type="checkbox" data-kt-check="true" value="Cyber Vigilance" />  Cyber Vigilance
                                </div>
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input  name="devis[]" class="form-check-input" type="checkbox" data-kt-check="true" value="Integrity" /> Integrity
                                </div>
                            </div>
                        </div>
                                                    
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="askForQuoteBtn">Demander un devis</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->