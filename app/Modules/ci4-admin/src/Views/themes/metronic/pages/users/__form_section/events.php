<!--begin:::Tab pane-->
<div class="tab-pane fade" id="kt_user_view_overview_events_and_logs_tab" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Login Sessions</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Filter-->
                <a href="<?= route_to('user-delete-sessions', $form->uuid); ?>"  type="button" class="btn btn-sm btn-flex btn-light-primary" id="kt_modal_sign_out_sesions">
                    <?= service('theme')->getSVG('icons/duotune/arrows/arr077.svg', "svg-icon svg-icon-3"); ?>
                    Sign out all sessions
                </a>
                <!--end::Filter-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session"> 
                    <?= view('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_browser_session', ['form' => $form]) ?>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Connexions</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Button-->
                <button type="button" class="btn btn-sm btn-light-primary">
                    <?= service('theme')->getSVG('icons/duotune/files/fil021.svg', "svg-icon svg-icon-3"); ?>
                    Download Report
                </button>
                <!--end::Button-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-0">
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fw-bold text-gray-600 fs-6 gy-5" id="kt_table_users_connexions">
                    <?= view('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_connexions', ['form' => $form]) ?>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Events & Logs</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Button-->
                <button type="button" class="btn btn-sm btn-light-primary">
                    <?= service('theme')->getSVG('icons/duotune/files/fil021.svg', "svg-icon svg-icon-3"); ?>
                    Download Report
                </button>
                <!--end::Button-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 text-gray-600 fw-bold gy-5" id="kt_table_users_logs">
                <?= view('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_logs', ['form' => $form]) ?>                
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>
<!--end:::Tab pane-->