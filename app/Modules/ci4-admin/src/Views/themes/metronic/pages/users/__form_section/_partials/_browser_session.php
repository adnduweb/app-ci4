 <!--begin::Table head-->
 <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
    <!--begin::Table row-->
    <tr class="text-start text-muted text-uppercase gs-0">
        <th class="min-w-100px">Location</th>
        <th>Device</th>
        <th>IP Address</th>
        <th class="min-w-125px">Time</th>
        <th class="min-w-70px">Actions</th>
    </tr>
    <!--end::Table row-->
</thead>
<!--end::Table head-->
<!--begin::Table body-->
<tbody class="fs-6 fw-bold text-gray-600">
<?php if (!empty($form->sessions)) { ?>
        <?php foreach ($form->sessions as $session) { ?>
            <?php $agent = new WhichBrowser\Parser($session->user_agent); ?>
            <?php if($session->ip_address != '127.0.0.1'){ ?>
                <tr>
                    <!--begin::Invoice=-->
                    <?php $details = json_decode(file_get_contents("https://ip-api.io/json/$session->ip_address")); //$details = json_decode(file_get_contents("https://ip-api.io/json/" . $session->ip_address)); // ?>
                    <td><?= $details->country_name; ?> <?= $details->city; ?></td>
                    <!--end::Invoice=-->
                    <!--begin::Status=-->
                    <td>  <?= $agent->browser->name; ?> | <?= $agent->device->model; ?><br/> <small><?= $agent->os->toString(); ?></small></td>
                    <!--end::Status=-->
                    <!--begin::Amount=-->
                    <td><?= $session->ip_address; ?></td>
                    <!--end::Amount=-->
                    <!--begin::Date=-->
                    <td><?= \CodeIgniter\I18n\Time::createFromTimestamp($session->timestamp)->humanize() ?></td>
                    <!--end::Date=-->
                    <!--begin::Action=-->
                    <td>
                        <?php if($session->id != session_id() ){ ?>
                            <a href="#" data-kt-users-sign-out="single_user">Sign out</a>
                        <?php }else  if($session->id == session_id() ){ ?>
                           Current Session
                        <?php } ?>
                    </td>
                    <!--end::Action=-->
                </tr>
            <?php } ?>
    <?php } ?>

<?php } ?>
</tbody>
<!--end::Table body-->