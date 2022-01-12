<?php  if(!empty($form->two_factor) && $form->two_factor == '2fa'){ ?>

    <!--begin::Card body-->
 <div class="card-body pb-5">
    <!--begin::Item-->
    <div class="d-flex flex-stack">
        <!--begin::Content-->
        <div class="d-flex flex-column example w-100">
            <span class="mb-5">Application Mobile</span>
            <span class="text-muted fs-6 example-code p-10">
            <span class="example-copy" data-bs-toggle="tooltip" data-bs-trigger="hover" title="" data-bs-original-title="Copy code"></span>
                <?php $two_factor_recovery_codes = json_decode(openssl_decrypt($form->auth_users_two_factors[0]->two_factor_recovery_codes,"AES-128-ECB",config('Encryption')->key)); ?>
                <span class=" language-html">
                    <span class=" language-html">
                        <?php foreach($two_factor_recovery_codes as $code ){ ?>
                            <?= $code; ?><br/>
                        <?php } ?>
                    </span>
                </span>          

            </span>
        </div>
        <!--end::Content-->
        <!--begin::Action-->
        <div class="d-flex justify-content-end align-items-center">
            <!--begin::Button-->
            <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" id="kt_users_delete_two_step">
                <?= service('theme')->getSVG('duotune/general/gen027.svg', "svg-icon svg-icon-3"); ?>
            </button>
            <!--end::Button-->
        </div>
        <!--end::Action-->
    </div>
    <!--end::Item-->
    <!--begin:Separator-->
    <div class="separator separator-dashed my-5"></div>
    <!--end:Separator-->
    <!--begin::Disclaimer-->
    <div class="text-gray-600">Utilisez ces codes si vous perdez ou n’avez pas accès à votre application <a href="#" data-kt-regereration-code-2fa="recovery-code" class="me-1">Vous pouvez les regénerer ici</a></div>
    <!--end::Disclaimer-->
</div>
<!--end::Card body-->

<?php } ?>


<?php  if(!empty($form->two_factor) && $form->two_factor == '2fa_sms'){ ?>
<!--begin::Card body-->
 <div class="card-body pb-5">
    <!--begin::Item-->
    <div class="d-flex flex-stack">
        <!--begin::Content-->
        <div class="d-flex flex-column">
            <span>SMS</span>
            <span class="text-muted fs-6"><?= $form->auth_users_two_factors[0]->opt_mobile; ?></span>
        </div>
        <!--end::Content-->
        <!--begin::Action-->
        <div class="d-flex justify-content-end align-items-center">
            <!--begin::Button-->
            <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" id="kt_users_delete_two_step">
                <?= service('theme')->getSVG('duotune/general/gen027.svg', "svg-icon svg-icon-3"); ?>
            </button>
            <!--end::Button-->
        </div>
        <!--end::Action-->
    </div>
    <!--end::Item-->
    <!--begin:Separator-->
    <div class="separator separator-dashed my-5"></div>
    <!--end:Separator-->
    <!--begin::Disclaimer-->
    <div class="text-gray-600">If you lose your mobile device or security key, you can 
    <a href="#" class="me-1">generate a backup code</a>to sign in to your account.</div>
    <!--end::Disclaimer-->
</div>
<!--end::Card body-->

<?php } ?>
