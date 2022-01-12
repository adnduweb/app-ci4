<?php use \Adnduweb\Ci4Admin\Libraries\Theme;?>
<div class="card-body p-0">

        <?php if (!empty($getSessionsUser)) { ?>
        <?php foreach ($getSessionsUser as $session) { ?>

                <!--end::Badge-->
                <!--begin::Text-->
                <div class="font-weight-mormal font-size-lg timeline-content text-muted pl-3">
                <?php
                    $agent = new WhichBrowser\Parser($session->user_agent);
                    //  print_r($agent); exit;
                    if ($agent->isType('desktop') == true) { ?>
                        <?= Theme::getSVG('media/svg/icons/Devices/Display3.svg', 'svg-icon-xl svg-icon-primary'); ?>
                            <?= ucfirst(lang('Core.desktop')); ?> |
                            <?= $agent->browser->name . ' ' . $agent->browser->version->value; ?> |
                            <?= $agent->os->toString(); ?>  | <?= $agent->device->model; ?>
                    <?php } ?>
                    <?php  if ($agent->isType('mobile') == true) {  ?>
                        <?= Theme::getSVG('media/svg/icons/Devices/iPhone-X.svg', 'svg-icon-xl svg-icon-primary'); ?>
                            <?= ucfirst(lang('Core.Mobile')); ?> |
                            <?= $agent->browser->name . ' ' . $agent->browser->version->value; ?> |
                            <?= $agent->os->toString(); ?> | <?= $agent->device->model; ?> | <?= $agent->device->identifier; ?>
                    <?php } ?>
                    <?php  if ($agent->isType('tablet') == true) {  ?>
                        <?= Theme::getSVG('media/svg/icons/Devices/Tablet.svg', 'svg-icon-xl svg-icon-primary'); ?>
                            <?= ucfirst(lang('Core.Tablet')); ?> |
                            <?= $agent->browser->name . ' ' . $agent->browser->version->value; ?> |
                            <?= $agent->os->toString(); ?> | <?= $agent->device->model; ?>
                    <?php } ?><br/>

                    <a href="#" class="text-primary">#<?=  $session->ip_address; ?></a> <?= ($session->id == session_id()) ? '<span class="text-bold text-success">'.lang('Core.this_device').'</span>' : '' ?>
                </div>
        <?php } ?>

        <button type="button" class="btn btn-danger btn-elevate deleteSessionBrowser mt-10"><?= lang('Core.session_en_cours_a_supprrimer');?></button>
    <?php } ?>

</div>

