<?php if(isset($notices) && count($notices) > 0){ ?>
    <!--begin::Notice-->
<div class="container mb-5">
    <div class="card mb-5 mb-xxl-8">
        <div class="card-body pt-9 pb-9">
            <?php foreach($notices as $notice){ ?>
                <div class=" <?= count($notices) >1 ? 'mb-5' : ''; ?>">
                    <?= $notice; ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!--end::Notice-->
<?php } ?>