<tbody>
<?php if (!empty($form->logs)) { ?>
        <?php foreach ($form->logs as $log) { ?>
        <!--begin::Table row-->
        <tr>
            <!--begin::Event=-->
             <!--begin::Badge=-->
            <td class="min-w-70px">
                <?php if($log->event =='insert'){ ?>
                    <div class="badge badge-light-success"><?= $log->event ?></div>
                <?php }else  if($log->event =='update'){ ?>
                    <div class="badge badge-light-warning"><?= $log->event ?></div>
                <?php }else{ ?>
                    <div class="badge badge-light-danger"><?= $log->event ?></div>
                    <?php } ?>
                
            </td>
            <!--end::Badge=-->
            <!--begin::source=-->
            <td><?= $log->source ?></td>
            <!--end::source=-->

            <!--begin::source=-->
            <?php if(!empty($log->data)){ ?>
                <td><?php $data = json_decode($log->data); ?> id : <?=  (!is_array($data->id) && !empty($data)) ? $data->id : $data->id[0]; ?></td>
            <?php }else{ ?>
                <td> -- </td>
            <?php } ?>
            <!--end::source=-->


            <!--begin::Timestamp=-->
            <td class="pe-0 text-end min-w-200px"><?= \CodeIgniter\I18n\Time::parse($log->created_at)->humanize() ?></td>
                <!--end::Timestamp=-->
        </tr>
        <!--end::Table row-->
        <?php } ?>
    <?php } ?>
      
    </tbody>
<!--end::Table body-->