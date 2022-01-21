<?php if (Config('Theme')->layout['extras']['user']['dropdown']['style'] == 'light'){ ?>

    <div class="d-flex align-items-center p-8 rounded-top">
        <div class="symbol symbol-md bg-light-primary mr-3 flex-shrink-0">
            <img src="<?= assetAdmin('/media/users/300_21.jpg'); ?>" alt=""/>
        </div>
    
        <div class="text-dark m-0 flex-grow-1 mr-3 font-size-h5"><?= user()->firstname[0]; ?> <?= user()->lastname[0]; ?></div>
        <span class="label label-light-success label-lg font-weight-bold label-inline">3 messages</span>
    </div>
    <div class="separator separator-solid"></div>
<?php }else{ ?>

    <div class="d-flex align-items-center justify-content-between flex-wrap p-8 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url('<?= assetAdmin('/media/misc/bg-1.jpg'); ?>')">
        <div class="d-flex align-items-center mr-2">

            <div class="symbol bg-white-o-15 mr-3">
                <span class="symbol-label text-success font-weight-bold font-size-h4"><?= user()->firstname[0]; ?> <?= user()->lastname[0]; ?></span>
            </div>

            <div class="text-white m-0 flex-grow-1 mr-3 font-size-h5"><?= user()->firstname; ?> <?= user()->lastname; ?></div>
            <span class="label label-success label-lg font-weight-bold label-inline"><?= user()->email; ?></span>
        </div>
        
    </div>
<?php } ?>


<div class="navi navi-spacer-x-0 pt-5">
    <a href="<?= CI_AREA_ADMIN; ?>/settings-advanced/users/edit/<?= user()->uuid; ?>" class="navi-item  px-8">
        <div class="navi-link">
            <div class="navi-icon mr-2">
                <i class="flaticon2-calendar-3 text-success"></i>
            </div>
            <div class="navi-text">
                <div class="font-weight-bold">
                    <?= lang('Core.my_profile'); ?>
                </div>
                <div class="text-muted">
                    <?= lang('Core.account_settings_and_more'); ?>
                </div>
            </div>
        </div>
    </a>

    <a href="#"  class="navi-item px-8">
        <div class="navi-link">
            <div class="navi-icon mr-2">
                <i class="flaticon2-mail text-warning"></i>
            </div>
            <div class="navi-text">
                <div class="font-weight-bold">
                    My Messages
                </div>
                <div class="text-muted">
                    Inbox and tasks
                </div>
            </div>
        </div>
    </a>

    <a href="#"  class="navi-item px-8">
        <div class="navi-link">
            <div class="navi-icon mr-2">
                <i class="flaticon2-rocket-1 text-danger"></i>
            </div>
            <div class="navi-text">
                <div class="font-weight-bold">
                    My Activities
                </div>
                <div class="text-muted">
                    Logs and notifications
                </div>
            </div>
        </div>
    </a>

    <a href="<?= CI_AREA_ADMIN; ?>/settings-advanced/users/edit/<?= user()->uuid; ?>" class="navi-item  px-8">
        <div class="navi-link">
            <div class="navi-icon mr-2">
                <i class="flaticon2-hourglass text-primary"></i>
            </div>
            <div class="navi-text">
                <div class="font-weight-bold">
                    My Tasks
                </div>
                <div class="text-muted">
                    latest tasks and projects
                </div>
            </div>
        </div>
    </a>

    <div class="navi-separator mt-3"></div>
    <div class="navi-footer  px-8 py-5">
        <a href="/<?= CI_AREA_ADMIN; ?>/logout" class="btn btn-light-primary font-weight-bold"><?= lang('Core.sign_out'); ?></a>
        <a href="#" target="_blank" class="btn btn-clean font-weight-bold">Upgrade Plan</a>
    </div>
</div>
