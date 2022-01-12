<!--begin::Connected Accounts-->
<div class="card mb-5 mb-xl-8 card_2">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <div class="card-title">
            <h3 class="fw-bolder m-0">Connected Accounts</h3>
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-2">
        <!--begin::Notice-->
        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
            <!--begin::Icon-->
            <?= service('theme')->getSVG('icons/duotune/art/art006.svg', "svg-icon svg-icon-2tx svg-icon-primary me-4"); ?>
            <!--end::Icon-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack flex-grow-1">
                <!--begin::Content-->
                <div class="fw-bold">
                    <div class="fs-6 text-gray-700">By connecting an account, you hereby agree to our 
                    <a href="#" class="me-1">privacy policy</a>and 
                    <a href="#">terms of use</a>.</div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Notice-->
        <!--begin::Items-->
        <div class="py-2">
            <!--begin::Item-->
            <div class="d-flex flex-stack">
                <div class="d-flex">
                    <img src="/metronic8/demo1/assets/media/svg/brand-logos/google-icon.svg" class="w-30px me-6" alt="">
                    <div class="d-flex flex-column">
                        <a href="#" class="fs-5 text-dark text-hover-primary fw-bolder">Google</a>
                        <div class="fs-6 fw-bold text-muted">Plan properly your workflow</div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <!--begin::Switch-->
                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                        <!--begin::Input-->
                        <input class="form-check-input" name="google" type="checkbox" value="1" id="kt_modal_connected_accounts_google" checked="checked" kl_vkbd_parsed="true">
                        <!--end::Input-->
                        <!--begin::Label-->
                        <span class="form-check-label fw-bold text-muted" for="kt_modal_connected_accounts_google"></span>
                        <!--end::Label-->
                    </label>
                    <!--end::Switch-->
                </div>
            </div>
            <!--end::Item-->
            <div class="separator separator-dashed my-5"></div>
            <!--begin::Item-->
            <div class="d-flex flex-stack">
                <div class="d-flex">
                    <img src="/metronic8/demo1/assets/media/svg/brand-logos/github.svg" class="w-30px me-6" alt="">
                    <div class="d-flex flex-column">
                        <a href="#" class="fs-5 text-dark text-hover-primary fw-bolder">Github</a>
                        <div class="fs-6 fw-bold text-muted">Keep eye on on your Repositories</div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <!--begin::Switch-->
                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                        <!--begin::Input-->
                        <input class="form-check-input" name="github" type="checkbox" value="1" id="kt_modal_connected_accounts_github" checked="checked" kl_vkbd_parsed="true">
                        <!--end::Input-->
                        <!--begin::Label-->
                        <span class="form-check-label fw-bold text-muted" for="kt_modal_connected_accounts_github"></span>
                        <!--end::Label-->
                    </label>
                    <!--end::Switch-->
                </div>
            </div>
            <!--end::Item-->
            <div class="separator separator-dashed my-5"></div>
            <!--begin::Item-->
            <div class="d-flex flex-stack">
                <div class="d-flex">
                    <img src="/metronic8/demo1/assets/media/svg/brand-logos/slack-icon.svg" class="w-30px me-6" alt="">
                    <div class="d-flex flex-column">
                        <a href="#" class="fs-5 text-dark text-hover-primary fw-bolder">Slack</a>
                        <div class="fs-6 fw-bold text-muted">Integrate Projects Discussions</div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <!--begin::Switch-->
                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                        <!--begin::Input-->
                        <input class="form-check-input" name="slack" type="checkbox" value="1" id="kt_modal_connected_accounts_slack" kl_vkbd_parsed="true">
                        <!--end::Input-->
                        <!--begin::Label-->
                        <span class="form-check-label fw-bold text-muted" for="kt_modal_connected_accounts_slack"></span>
                        <!--end::Label-->
                    </label>
                    <!--end::Switch-->
                </div>
            </div>
            <!--end::Item-->
        </div>
        <!--end::Items-->
    </div>
    <!--end::Card body-->
    <!--begin::Card footer-->
    <div class="card-footer border-0 d-flex justify-content-center pt-0">
        <button class="btn btn-sm btn-light-primary">Save Changes</button>
    </div>
    <!--end::Card footer-->
</div>
<!--end::Connected Accounts-->