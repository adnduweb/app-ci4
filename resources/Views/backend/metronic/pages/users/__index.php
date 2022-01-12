<?php use \Adnduweb\Ci4Admin\Libraries\Theme; ?>
<?= $this->extend('Themes\backend\metronic\layout\admin') ?>
<?= $this->section('main') ?>

    <div class="container-fluid">
        <div class="flex-row ">
            <div class="card">
                <!-- <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="card-label"><?= lang('Core.record_selection'); ?>
                            <span class="d-block text-muted pt-2 font-size-sm"><?= lang('Core.row_selection_and_group_actions'); ?></span></h3>
                    </div>
                    <?php if ($toolbarExport == true) { ?>
                        <div class="card-toolbar">
                            <?= $this->include('Themes\backend\metronic\layout\partials\extras\_export_data') ?>
                        </div>
                    <?php } ?>
                </div> -->

                <div class="card-header border-0 pt-6">
										<!--begin::Card title-->
										<div class="card-title">
											<!--begin::Search-->
											<div class="d-flex align-items-center position-relative my-1">
												<!--begin::Svg Icon | path: icons/duotone/General/Search.svg-->
												<span class="svg-icon svg-icon-1 position-absolute ms-6">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
															<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
														</g>
													</svg>
												</span>
												<!--end::Svg Icon-->
												<input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search users" />
											</div>
											<!--end::Search-->
										</div>
										<!--begin::Card title-->
										<!--begin::Card toolbar-->
										<div class="card-toolbar">
											<!--begin::Toolbar-->
											<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
												<!--begin::Filter-->
												<button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
												<!--begin::Svg Icon | path: icons/duotone/Text/Filter.svg-->
												<span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="#000000" />
														</g>
													</svg>
												</span>
												<!--end::Svg Icon-->Filter</button>
												<!--begin::Menu 1-->
												<div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
													<!--begin::Header-->
													<div class="px-7 py-5">
														<div class="fs-4 text-dark fw-bolder">Filter Options</div>
													</div>
													<!--end::Header-->
													<!--begin::Separator-->
													<div class="separator border-gray-200"></div>
													<!--end::Separator-->
													<!--begin::Content-->
													<div class="px-7 py-5">
														<!--begin::Input group-->
														<div class="mb-10">
															<!--begin::Label-->
															<label class="form-label fs-5 fw-bold mb-3">Month:</label>
															<!--end::Label-->
															<!--begin::Input-->
															<select class="form-select form-select-solid fw-bolder" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="month" data-dropdown-parent="#kt-toolbar-filter">
																<option></option>
																<option value="aug">August</option>
																<option value="sep">September</option>
																<option value="oct">October</option>
																<option value="nov">November</option>
																<option value="dec">December</option>
															</select>
															<!--end::Input-->
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="mb-10">
															<!--begin::Label-->
															<label class="form-label fs-5 fw-bold mb-3">Payment Type:</label>
															<!--end::Label-->
															<!--begin::Options-->
															<div class="d-flex flex-column flex-wrap fw-bold" data-kt-user-table-filter="payment_type">
																<!--begin::Option-->
																<label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
																	<input class="form-check-input" type="radio" name="payment_type" value="all" checked="checked" />
																	<span class="form-check-label text-gray-600">All</span>
																</label>
																<!--end::Option-->
																<!--begin::Option-->
																<label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
																	<input class="form-check-input" type="radio" name="payment_type" value="visa" />
																	<span class="form-check-label text-gray-600">Visa</span>
																</label>
																<!--end::Option-->
																<!--begin::Option-->
																<label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
																	<input class="form-check-input" type="radio" name="payment_type" value="mastercard" />
																	<span class="form-check-label text-gray-600">Mastercard</span>
																</label>
																<!--end::Option-->
																<!--begin::Option-->
																<label class="form-check form-check-sm form-check-custom form-check-solid">
																	<input class="form-check-input" type="radio" name="payment_type" value="american_express" />
																	<span class="form-check-label text-gray-600">American Express</span>
																</label>
																<!--end::Option-->
															</div>
															<!--end::Options-->
														</div>
														<!--end::Input group-->
														<!--begin::Actions-->
														<div class="d-flex justify-content-end">
															<button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
															<button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Apply</button>
														</div>
														<!--end::Actions-->
													</div>
													<!--end::Content-->
												</div>
												<!--end::Menu 1-->
												<!--end::Filter-->
												<!--begin::Export-->
												<button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_users_export_modal">
												<!--begin::Svg Icon | path: icons/duotone/Files/Export.svg-->
												<span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
															<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) scale(1, -1) rotate(-180.000000) translate(-12.000000, -8.000000)" x="11" y="2" width="2" height="12" rx="1" />
															<path d="M12,2.58578644 L14.2928932,0.292893219 C14.6834175,-0.0976310729 15.3165825,-0.0976310729 15.7071068,0.292893219 C16.0976311,0.683417511 16.0976311,1.31658249 15.7071068,1.70710678 L12.7071068,4.70710678 C12.3165825,5.09763107 11.6834175,5.09763107 11.2928932,4.70710678 L8.29289322,1.70710678 C7.90236893,1.31658249 7.90236893,0.683417511 8.29289322,0.292893219 C8.68341751,-0.0976310729 9.31658249,-0.0976310729 9.70710678,0.292893219 L12,2.58578644 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 2.500000) scale(1, -1) translate(-12.000000, -2.500000)" />
														</g>
													</svg>
												</span>
												<!--end::Svg Icon-->Export</button>
												<!--end::Export-->
												<!--begin::Add user-->
												<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
												<!--begin::Svg Icon | path: icons/duotone/Navigation/Plus.svg-->
												<span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
														<rect fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="4" y="11" width="16" height="2" rx="1" />
													</svg>
												</span>
												<!--end::Svg Icon-->Add user</button>
												<!--end::Add user-->
											</div>
											<!--end::Toolbar-->
											<!--begin::Group actions-->
											<div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
												<div class="fw-bolder me-5">
												<span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
												<button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
											</div>
											<!--end::Group actions-->
										</div>
										<!--end::Card toolbar-->
									</div>
									<!--end::Card header-->
                <div class="card-body pt-0">
                    <!--begin: Datatable -->
                    <!-- <div class="datatable datatable-bordered datatable-head-custom" id="kt_apps_user_list_datatable"></div> -->
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="users-table">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#users_table .form-check-input" value="1" />
                                    </div>
                                </th>
                                <th class="min-w-125px" title="Name Lastname"><?= lang('Users.Nom et Prénom'); ?></th>
                                <th class="min-w-125px" title="Email"><?= lang('Users.Nom et Prénom'); ?></th>
                                <th class="min-w-125px" title="Tel"><?= lang('Users.Nom et Prénom'); ?></th>
                                <th class="min-w-125px" title="Role"><?= lang('Users.Nom et Prénom'); ?></th>
                                <th class="min-w-125px" title="Active"><?= lang('Users.Affichée'); ?></th>
                                <th class="min-w-125px" title="Created At"><?= lang('Users.Date de Création'); ?></th>
                                <th class="text-end min-w-70px" title="Action"><?= lang('Users.Actions'); ?></th>
                            </tr>
                        </thead>
                    </table>
                    <!--end::Table-->

                </div>
                <!--end: Datatable -->
            </div>
        </div>
    </div>

    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">Actions 
														<!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-down.svg-->
														<span class="svg-icon svg-icon-5 m-0">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24"></polygon>
																	<path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
																</g>
															</svg>
														</span>
                                                        <!--end::Svg Icon--></a>
                                                        
                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true" style="">
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="/metronic8/demo1/../demo1/apps/customers/view.html" class="menu-link px-3">View</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="#" class="menu-link px-3" data-kt-customer-table-filter="delete_row">Delete</a>
															</div>
															<!--end::Menu item-->
														</div>

    <!--end::Portlet-->

    <!--begin::Modal-->
    <?= $this->include('Themes\backend\metronic\layout\partials\extras\_datatable_records_fetch_modal') ?>
    <!--end::Modal-->


<?= $this->endSection() ?>

<?= $this->section('page_toolbar_left') ?>

    <?php if (inGroups(1, user()->id) && $fakedata == true) { ?>
        <a href="/<?= env('CI_AREA_ADMIN'); ?><?= str_replace('add', 'fake', $addPathController); ?>/10" data-toggle="kt-tooltip" title="<?= lang('Core.Fake data'); ?>" data-placement="bottom" data-original-title="<?= lang('Core.Fake data'); ?>" class="btn btn-sm btn-icon btn-bg-light btn-icon-primary btn-hover-primary"> <i class="flaticon2-gear"></i>
        </a>
    <?php } ?>
    <?php if (isset($add) && $add == true) { ?>
        <a href="/<?= env('app.areaAdmin'); ?><?= $addPathController; ?>" class="btn btn-primary font-weight-bolder btn-sm">
        <?= Theme::getSVG('svg/icons/Design/Flatten.svg', 'svg-icon svg-icon-sm', true); ?> 
        <?= $add; ?> </a>
    <?php } ?>

<?= $this->endSection() ?>


<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">



"use strict";

// Class definition
var UsersList = function () {
    // Define shared variables
    var datatable;
    var filterMonth;
    var filterPayment;
    var table

    // Private functions
    var inituserList = function () {
        // Set date data order
        const tableRows = table.querySelectorAll('tbody tr');

        tableRows.forEach(row => {
            const dateRow = row.querySelectorAll('td');
            // const realDate = moment(dateRow[4].innerHTML, "DD MMM YYYY, LT").format(); // select date from 5th column in table
            // dateRow[5].setAttribute('data-order', realDate);
        });

        // Init datatable --- more info on datatables: https://datatables.net/manual/
        datatable = $(table).DataTable({
            "info": false,
            "serverSide": true,
            "processing": true,
            "ajax": {
            // "url": "https:\/\/preview.keenthemes.com\/metronic8\/laravel\/log\/audit",
                "url": current_url + "/list",
                "type": "GET",
                // "data": function(data) {
                //     for (var i = 0, len = data.columns.length; i < len; i++) {
                //         if (!data.columns[i].search.value) delete data.columns[i].search;
                //         if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                //         if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                //         if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
                //     }
                //     delete data.search.regex;
                // }
            },
            //'order': [],
            'columns': [
				{data: 'id'},
				{data: 'lastname'},
				{data: 'firstname'},
				{data: 'email'},
				{data: 'email'},
				{data: 'email'},
				{data: 'email'},
				{data: 'Actions', responsivePriority: -1},
			],
            'columnDefs': [
                { orderable: false, targets: 0 }, // Disable ordering on column 0 (checkbox)
                //{ orderable: false, targets: 6 }, // Disable ordering on column 6 (actions)
                {
					targets: -1,
					title: 'Actions',
					orderable: false,
					render: function(data, type, full, meta) {
                        console.log('dfgsdgsdfgdsfg');
                        KTMenu.init();
						// return '\
						// 	<div class="dropdown dropdown-inline">\
						// 		<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown">\
	                    //             <i class="la la-cog"></i>\
	                    //         </a>\
						// 	  	<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">\
						// 			<ul class="nav nav-hoverable flex-column">\
						// 	    		<li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-edit"></i><span class="nav-text">Edit Details</span></a></li>\
						// 	    		<li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-leaf"></i><span class="nav-text">Update Status</span></a></li>\
						// 	    		<li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-print"></i><span class="nav-text">Print</span></a></li>\
						// 			</ul>\
						// 	  	</div>\
						// 	</div>\
						// 	<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
						// 		<i class="la la-edit"></i>\
						// 	</a>\
						// 	<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Delete">\
						// 		<i class="la la-trash"></i>\
						// 	</a>\
                        // ';
                        
                        return '<a href="javascript:;" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">Actions \
                            <!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-down.svg-->\
                            <span class="svg-icon svg-icon-5 m-0">\
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>\
                                        <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>\
                                    </g>\
                                </svg>\
                            </span>\
                            <!--end::Svg Icon--></a>\
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">\
                                <!--begin::Menu item-->\
                                <div class="menu-item px-3">\
                                    <a href="/metronic8/demo1/../demo1/apps/customers/view.html" class="menu-link px-3">View</a>\
                                </div>\
                                <!--end::Menu item-->\
                                <!--begin::Menu item-->\
                                <div class="menu-item px-3">\
                                    <a href="#" class="menu-link px-3" data-kt-customer-table-filter="delete_row">Delete</a>\
                                </div>\
                                <!--end::Menu item-->\
                            </div>\
                            ';
					},
				},
            ],
           
            // "columns": [{
            //     "data": "id",
            //     "name": "id",
            //     "title": "Log ID",
            //     "orderable": true,
            //     "searchable": true
            // }, {
            //     "data": "lastname",
            //     "name": "lastname",
            //     "title": "Location",
            //     "orderable": true,
            //     "searchable": true
            // }, {
            //     "data": "firstname",
            //     "name": "firstname",
            //     "title": "Description",
            //     "orderable": true,
            //     "searchable": true
            // }, {
            //     "data": "email",
            //     "name": "email",
            //     "title": "Subject Type",
            //     "orderable": true,
            //     "searchable": true
            // }, {
            //     "data": "email",
            //     "name": "email",
            //     "title": "Subject",
            //     "orderable": true,
            //     "searchable": true
            // }, {
            //     "data": "email",
            //     "name": "email",
            //     "title": "Causer",
            //     "orderable": true,
            //     "searchable": true
            // }, {
            //     "data": "created_at",
            //     "name": "created_at",
            //     "title": "Created At",
            //     "orderable": true,
            //     "searchable": true
            // }, {
            //     "data": "action",
            //     "name": "action",
            //     "title": "Action",
            //     "orderable": false,
            //     "searchable": false,
            //     "className": "text-center",
            //     "responsivePriority": -1
            // }],
            "stateSave": true,
            "order": [
                [6, "desc"]
            ],
            "responsive": true,
            "autoWidth": false,
            "scrollX": true
        });

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        datatable.on('draw', function () {
            initToggleToolbar();
            handleDeleteRows();
            toggleToolbars();
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Filter Datatable
    var handleFilterDatatable = () => {
        // Select filter options
        filterMonth = $('[data-kt-user-table-filter="month"]');
        filterPayment = document.querySelectorAll('[data-kt-user-table-filter="payment_type"] [name="payment_type"]');
        const filterButton = document.querySelector('[data-kt-user-table-filter="filter"]');

        // Filter datatable on submit
        filterButton.addEventListener('click', function () {
            // Get filter values
            const monthValue = filterMonth.val();
            let paymentValue = '';

            // Get payment value
            filterPayment.forEach(r => {
                if (r.checked) {
                    paymentValue = r.value;
                }

                // Reset payment value if "All" is selected
                if (paymentValue === 'all') {
                    paymentValue = '';
                }
            });

            // Build filter string from filter options
            const filterString = monthValue + ' ' + paymentValue;

            // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
            datatable.search(filterString).draw();
        });
    }

    // Delete users
    var handleDeleteRows = () => {
        // Select all delete buttons
        const deleteButtons = table.querySelectorAll('[data-kt-user-table-filter="delete_row"]');

        deleteButtons.forEach(d => {
            // Delete button on click
            d.addEventListener('click', function (e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest('tr');

                // Get users name
                const userName = parent.querySelectorAll('td')[1].innerText;

                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "Are you sure you want to delete " + userName + "?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                        Swal.fire({
                            text: "You have deleted " + userName + "!.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        }).then(function () {
                            // Remove current row
                            datatable.row($(parent)).remove().draw();
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: userName + " was not deleted.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                });
            })
        });
    }

    // Reset Filter
    var handleResetForm = () => {
        // Select reset button
        const resetButton = document.querySelector('[data-kt-user-table-filter="reset"]');

        // Reset datatable
        resetButton.addEventListener('click', function () {
            // Reset month
            filterMonth.val(null).trigger('change');

            // Reset payment type
            filterPayment[0].checked = true;

            // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
            datatable.search('').draw();
        });
    }

    // Init toggle toolbar
    var initToggleToolbar = () => {
        // Toggle selected action toolbar
        // Select all checkboxes
        const checkboxes = table.querySelectorAll('[type="checkbox"]');

        // Select elements
        const deleteSelected = document.querySelector('[data-kt-user-table-select="delete_selected"]');

        // Toggle delete selected toolbar
        checkboxes.forEach(c => {
            // Checkbox on click event
            c.addEventListener('click', function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });

        // Deleted selected rows
        deleteSelected.addEventListener('click', function () {
            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
            Swal.fire({
                text: "Are you sure you want to delete selected users?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    Swal.fire({
                        text: "You have deleted all selected users!.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    }).then(function () {
                        // Remove all selected users
                        checkboxes.forEach(c => {
                            if (c.checked) {
                                datatable.row($(c.closest('tbody tr'))).remove().draw();
                            }
                        });

                        // Remove header checked box
                        const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
                        headerCheckbox.checked = false;
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Selected users was not deleted.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    });
                }
            });
        });
    }

    // Toggle toolbars
    const toggleToolbars = () => {
        // Define variables
        const toolbarBase = document.querySelector('[data-kt-user-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-user-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-user-table-select="selected_count"]');

        // Select refreshed checkbox DOM elements 
        const allCheckboxes = table.querySelectorAll('tbody [type="checkbox"]');

        // Detect checkboxes state & count
        let checkedState = false;
        let count = 0;

        // Count checked boxes
        allCheckboxes.forEach(c => {
            if (c.checked) {
                checkedState = true;
                count++;
            }
        });

        // Toggle toolbars
        if (checkedState) {
            selectedCount.innerHTML = count;
            toolbarBase.classList.add('d-none');
            toolbarSelected.classList.remove('d-none');
        } else {
            toolbarBase.classList.remove('d-none');
            toolbarSelected.classList.add('d-none');
        }
    }

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#users-table');
            
            if (!table) {
                return;
            }

            inituserList();
            initToggleToolbar();
            handleSearchDatatable();
            handleFilterDatatable();
            handleDeleteRows();
            handleResetForm();
           
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    UsersList.init();
});


// $(function() {
//     window.Ci4DataTables = window.Ci4DataTables || {};
//     window.Ci4DataTables["users-table"] = $("#users-table").DataTable({
//         "serverSide": true,
//         "processing": true,
//         "ajax": {
//            // "url": "https:\/\/preview.keenthemes.com\/metronic8\/laravel\/log\/audit",
//             "url": current_url + "/list",
//             "type": "GET",
//             "data": function(data) {
//                 for (var i = 0, len = data.columns.length; i < len; i++) {
//                     if (!data.columns[i].search.value) delete data.columns[i].search;
//                     if (data.columns[i].searchable === true) delete data.columns[i].searchable;
//                     if (data.columns[i].orderable === true) delete data.columns[i].orderable;
//                     if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
//                 }
//                 delete data.search.regex;
//             }
//         },
//         "columns": [{
//             "data": "id",
//             "name": "id",
//             "title": "Log ID",
//             "orderable": true,
//             "searchable": true
//         }, {
//             "data": "log_name",
//             "name": "log_name",
//             "title": "Location",
//             "orderable": true,
//             "searchable": true
//         }, {
//             "data": "description",
//             "name": "description",
//             "title": "Description",
//             "orderable": true,
//             "searchable": true
//         }, {
//             "data": "subject_type",
//             "name": "subject_type",
//             "title": "Subject Type",
//             "orderable": true,
//             "searchable": true
//         }, {
//             "data": "subject_id",
//             "name": "subject_id",
//             "title": "Subject",
//             "orderable": true,
//             "searchable": true
//         }, {
//             "data": "causer_id",
//             "name": "causer_id",
//             "title": "Causer",
//             "orderable": true,
//             "searchable": true
//         }, {
//             "data": "created_at",
//             "name": "created_at",
//             "title": "Created At",
//             "orderable": true,
//             "searchable": true
//         }, {
//             "data": "action",
//             "name": "action",
//             "title": "Action",
//             "orderable": false,
//             "searchable": false,
//             "className": "text-center",
//             "responsivePriority": -1
//         }, {
//             "data": "properties",
//             "name": "properties",
//             "title": "Properties",
//             "orderable": true,
//             "searchable": true,
//             "className": "none"
//         }],
//         "stateSave": true,
//         "order": [
//             [6, "desc"]
//         ],
//         "responsive": true,
//         "autoWidth": false,
//         "scrollX": true
//     });

//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     Ci4DataTables["users-table"].on('click', '[data-destroy]', function(e) {
//         e.preventDefault();
//         if (!confirm("Are you sure to delete this record?")) {
//             return;
//         }
//         axios.delete($(this).data('destroy'), {
//                 '_method': 'DELETE',
//             })
//             .then(function(response) {
//                 Ci4DataTables["users-table"].ajax.reload();
//             })
//             .catch(function(error) {
//                 console.log(error);
//             });
//     });

// });

</script>

<?= $this->endSection() ?>