<!--begin:::Tab pane-->
<div class="tab-pane fade active show" id="kt_user_view_overview_security" role="tabpanel">
    <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_profile') ?>
    <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_auth_two_step') ?>
    <?php if( user()->id == $form->id){ ?> 
        <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_notifications_email') ?>         
    <?php } ?>
</div>
