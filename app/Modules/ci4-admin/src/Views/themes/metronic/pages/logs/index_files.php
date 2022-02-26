<?= $this->extend('Themes\backend\metronic\admin') ?>
<?= $this->section('main') ?>
<div class="card ">
    <x-page-head>
        <h2>Logs</h2>
    </x-page-head>

    <x-admin-box>
            <?php if (count($logs)) { ?> 

                <form action="<?= route_to('log-delete-file'); ?>" method="post">
                    <?= csrf_field() ?>

                <div class="table-responsive">
                <table id="kt_log_manager_list" class="table align-middle table-row-dashed fs-6 gy-5 logs" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_log_manager_list .form-check-input" value="1" />
                                </div>
                            </th>
                            <th class="min-w-125px date "><?= lang('Logs.date'); ?></th>
                            <th class="min-w-125px file"><?= lang('Logs.file'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($logs as $log) :
                            // Skip the index.html file.
                            if ($log === 'index.html') {
                                continue;
                            }
                            ?>
                        <tr>
                            <td class="column-check">
                                 <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" name="checked[]" type="checkbox" value="<?= esc($log); ?>" />
                                </div>
                            </td>
                            <td class='date'>
                                <a href='<?= route_to('log-views-files', $log); ?>'>
                                    <?= date('F j, Y', strtotime(str_replace('.log', '', str_replace('log-', '', $log)))); ?>
                                </a>
                            </td>
                            <td><?= esc($log); ?></td>
                        </tr>
                            <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
                </div>
        <?= $pager->links('group1','metronic_simple') ?>

        <input type="submit" name="delete" id="delete-me" class="btn btn-sm btn-danger" value="<?= lang('Logs.delete_selected'); ?>" onclick="return confirm('<?= lang('Logs.delete_selected_confirm'); ?>')" />

        <input type="submit" value='<?= lang('Logs.delete_all'); ?>' name="delete_all" class="btn btn-sm btn-danger" onclick="return confirm('<?= lang('Logs.delete_all_confirm'); ?>')" />

        </form>
        <?php } else { ?>
        <div class="text-center">
            <i class="fas fa-clipboard-list fa-3x my-3"></i><br/> <?= lang('Logs.empty'); ?>
        </div>
    <?php } ?>
    </x-admin-box>
    </div>
<?php $this->endSection() ?>
