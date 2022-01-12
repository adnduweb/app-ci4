<!--begin::Table body-->
<tbody>
    <?php if (!empty($form->getLastlogins())) { ?>
            <?php foreach ($form->getLastlogins() as $login) { ?>
            <!--begin::Table row-->
            <tr>
                <!--begin::Badge=-->
                <td class="min-w-70px">
                    <div class="badge badge-light-success"><?= $login->ip_address; ?></div>
                </td>
                <!--end::Badge=-->
                <!--begin::Status=-->
                <td><?= $login->agent; ?></td> 
                <!--end::Status=-->
                <!--begin::Timestamp=-->
                <td class="pe-0 text-end min-w-200px"><?= \CodeIgniter\I18n\Time::parse($login->date)->humanize() ?></td>
                <!--end::Timestamp=-->
            </tr>
            <!--end::Table row-->
        <?php } ?>
    <?php } ?>
</tbody>
<!--end::Table body-->