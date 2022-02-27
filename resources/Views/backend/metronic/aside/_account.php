<div class="account-manager" id="accountManager">
    <div class="row">
        <div class="col-md-3 img-account">
            <img class="rounded-circle" src="<?= assetAdmin('/media/avatars/fl.jpg'); ?>"/>
        </div>
        <div class="col-md-8" id="infoManager">
                            <span class="account-name">fabrice Loru</span>
            <span class="account-function">Account Manager</span>
            <div class="wrap-icon-account-min pt-2">
           
                <span class="mx-2" data-bs-toggle="tooltip" title="" data-bs-original-title="Demander un devis" aria-label="Demander un devis"><i class="far fa-file-alt kt-font-primary"></i></span>
                <span class="mx-2" data-bs-toggle="tooltip" title="" data-bs-original-title="Demander un rendez-vous" aria-label="Demander un rendez-vous"><i class="far fa-calendar-alt kt-font-primary"></i></span>
                <span class="mx-2" data-bs-toggle="tooltip" title="" data-bs-original-title="Nous contacter" aria-label="Nous contacter"><i class="fas fa-envelope kt-font-primary"></i></span>
                <span class="mx-2" data-bs-toggle="tooltip" title="" data-bs-original-title="Autorisation d'accès" aria-label="Autorisation d'accès"><i class="fas fa-key kt-font-primary"></i></span>
            </div>
            <div class="wrap-infos-account pt-2 d-none">
                <span class="account-email">fabrice@adnduweb.com</span>
                <span class="account-phone">+33.6.84.63.53.90</span>
                <span class="account-city">Vannes, France.</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="wrap-btn-account-demande mt-3 d-none">
                <div class="col-md-6">
                    <span class="btn-account-devis">
                        <button type="button" class="btn btn-bold btn-label-brand btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_devis">
                            <i class="far fa-file-alt"></i> Devis
                        </button>
                    </span>
                </div>
                <div class="col-md-6">
                    <span class="btn-account-rdv"><button type="button" class="btn btn-bold btn-label-brand btn-sm" data-toggle="modal" data-target="#kt_modal_rdv"><i class="far fa-calendar-alt"></i> RDV</button></span>
                </div>
            </div>
            <div class="wrap-btn-account-demande mt-3 d-none">
                <div class="col-md-12">
                    <span class="btn-account-contact"><button type="button" class="btn btn-bold btn-label-brand btn-sm w-100 d-block" data-toggle="modal" data-target="#kt_modal_contact"><i class="fas fa-envelope"></i> Contact</button></span>
                </div>
            </div>
            <div class="wrap-btn-account-demande mt-3 d-none">
                <div class="col-md-12">
                    <span class="btn-account-contact"><button type="button" class="btn btn-bold btn-label-brand btn-sm w-100 d-block" data-toggle="modal" data-target="#kt_modal_am_access"><i class="fas fa-key"></i> Autorisation d'accès</button></span>
                </div>
            </div>
        </div>
    </div>
        <div class="wrap-btn-account" id="btnAccount">
            <button type="button" class="btn btn-sm btn-brand btn-icon"><i class="fas fa-chevron-up"></i></button>
        </div>
</div>