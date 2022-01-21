<!--begin::Modal - Users Search-->
<div class="modal fade" id="kt_modal_customer_search" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-650px">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header pb-0 border-0 justify-content-end">
				<!--begin::Close-->
				<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
					<?= service('theme')->getSVG('duotone/Navigation/Close.svg', "svg-icon svg-icon-1"); ?>
				</div>
				<!--end::Close-->
			</div>
			<!--begin::Modal header-->
			<!--begin::Modal body-->
			<div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
				<!--begin::Content-->
				<div class="text-center mb-12">
					<h1 class="fw-bolder mb-3"><?= lang('Core.search_users'); ?></h1>
					<div class="text-gray-400 fw-bold fs-5"><?= lang('Core.list_users_apps'); ?></div>
				</div>
				<!--end::Content-->
				<!--begin::Search-->
				<div id="kt_modal_customer_search_handler" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="inline">
					<!--begin::Form-->
					<form data-kt-search-element="form" class="w-100 position-relative mb-5" autocomplete="off">
						<!--begin::Hidden input(Added to disable form autocomplete)-->
						<input type="hidden" />
						<!--end::Hidden input-->
						<!--begin::Icon-->
						<?= service('theme')->getSVG('icons/duotune/general/gen021.svg', "svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y"); ?>
						<!--end::Icon-->
						<!--begin::Input-->
						<input type="text" class="form-control form-control-lg form-control-solid px-15" name="search" value="" placeholder="<?= lang('Core.search_by_username_full_name_or_email'); ?>..." data-kt-search-element="input" />
						<!--end::Input-->
						<!--begin::Spinner-->
						<span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5" data-kt-search-element="spinner">
							<span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
						</span>
						<!--end::Spinner-->
						<!--begin::Reset-->
						<span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 me-5 d-none" data-kt-search-element="clear">
							<?= service('theme')->getSVG('duotune/arrows/arr061.svg', "svg-icon svg-icon-2 svg-icon-lg-1 me-0"); ?>
						</span>
						<!--end::Reset-->
					</form>
					<!--end::Form-->
					<!--begin::Wrapper-->
					<div class="py-5">
						<!--begin::Suggestions-->
						<div data-kt-search-element="suggestions">
							<!--begin::Illustration-->
							<div class="text-center px-4 pt-10">
								<img src="<?= assetAdmin('/media/illustrations/sketchy-1/4.png'); ?>" alt="" class="mw-100 mh-200px" />
							</div>
							<!--end::Illustration-->
						</div>
						<!--end::Suggestions-->
						<!--begin::Results-->
						<div id="kt-search-users-element" data-kt-search-element="results" class="d-none">
							<?= view('Adnduweb\Ci4Admin\themes\metronic\pages\users\__partials\_search_users', ['list_users' => '']) ?>
						</div>
						<!--end::Results-->
						<!--begin::Empty-->
						<div data-kt-search-element="empty" class="text-center d-none">
							<!--begin::Message-->
							<div class="fw-bold py-0 mb-10">
								<div class="text-gray-600 fs-3 mb-2"><?= lang('Core.no_users_found'); ?></div>
								<div class="text-gray-400 fs-6"><?= lang('Core.try_search_by_username_full_name_or_email'); ?></div>
							</div>
							<!--end::Message-->
							<!--begin::Illustration-->
							<div class="text-center px-4">
								<img src="<?= assetAdmin('/media/illustrations/sketchy-1/9.png'); ?>" alt="user" class="mw-100 mh-200px" />
							</div>
							<!--end::Illustration-->
						</div>
						<!--end::Empty-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Search-->
			</div>
			<!--end::Modal body-->
		</div>
		<!--end::Modal content-->
	</div>
	<!--end::Modal dialog-->
</div>
<!--end::Modal - Users Search-->

<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">

"use strict";

// Class definition
var KTModalCustomerSelect = function() {
    // Private variables
	var element;
	var inputElement;
    var suggestionsElement;
    var resultsElement;
    var wrapperElement;
    var emptyElement;
    var searchObject;
    
    var modal;

    // Private functions
    var processs = function(search) {
        var timeout = setTimeout(function() {
			var number = KTUtil.getRandomInt(1, 6);
			
           // Hide recently viewed
            suggestionsElement.classList.add('d-none');

            if (inputElement.value.length >=  3) {

				axios.get("<?= route_to('user-list-ajax'); ?>", {params: {s: inputElement.value}})
				.then(response => {
					$('#kt-search-users-element').html(response.data.display_kt_search_users_element); // display the user
					if(response.data.count == 0){
						// Hide results
						resultsElement.classList.add('d-none');
						// Show empty message 
						emptyElement.classList.remove('d-none');
					}else{
						// Show results
						resultsElement.classList.remove('d-none');
						// Hide empty message 
						emptyElement.classList.add('d-none');
					}
                })
				.catch(function(error) {})
				.then(function() {});
			
			} else {
				// Hide results
				resultsElement.classList.add('d-none');
                // Show empty message 
                emptyElement.classList.remove('d-none');
            }                  

            // Complete search
            search.complete();
        }, 500);
    }

    var clear = function(search) {
        // Show recently viewed
        suggestionsElement.classList.remove('d-none');
        // Hide results
        resultsElement.classList.add('d-none');
        // Hide empty message 
        emptyElement.classList.add('d-none');
    }    

    // Public methods
	return {
		init: function() {
            // Elements
            element = document.querySelector('#kt_modal_customer_search_handler');
            modal = new bootstrap.Modal(document.querySelector('#kt_modal_customer_search'));

            if (!element) {
                return;
            }

			wrapperElement = element.querySelector('[data-kt-search-element="wrapper"]');
			inputElement = element.querySelector('[data-kt-search-element="input"]');
            suggestionsElement = element.querySelector('[data-kt-search-element="suggestions"]');
            resultsElement = element.querySelector('[data-kt-search-element="results"]');
			emptyElement = element.querySelector('[data-kt-search-element="empty"]');
			
			$(inputElement).keypress(function (evt) {

				var keycode = evt.charCode || evt.keyCode;
				if (keycode  == 13) { //Enter key's keycode
					return false;
				}
			});
            
            // Initialize search handler
			searchObject = new KTSearch(element);

            // Search handler
            searchObject.on('kt.search.process', processs);

            // Clear handler
            searchObject.on('kt.search.clear', clear);

            // Handle select
            KTUtil.on(element, '[data-kt-search-element="customer"]', 'click', function() {

				const packets = {
					uuid:  $(this).data('uuid')
				};
		
				axios.post('<?= route_to('user-entantque-comfirm'); ?>', packets)
				.then(response => {
					// response => alert(JSON.stringify(response.data))
					window.location.reload();
				})
				.catch(error => {
					console.log("ERROR:: ",error.response.data);
				});
               
            });
		}
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTModalCustomerSelect.init();
});

</script>

<?= $this->endSection() ?>