<?= $this->extend('Themes\backend\metronic\admin') ?>
<?= $this->section('main') ?>
<div class="card ">
<x-page-head>
    <a href="<?= route_to('log-list-files');?>" class="back">&larr; Logs</a>
    <h2>Logs : <?= $logFilePretty; ?></h2>
</x-page-head>

<x-admin-box>
    <div class="table-responsive">
        <table class="table align-middle table-row-dashed fs-6 gy-5 nowrap" id="log">
            <tr>
                <th class="min-w-125px"><?= lang('Logs.level'); ?></th>
                <th class="min-w-125px"><?= lang('Logs.date'); ?></th>
                <th class="min-w-125px"><?= lang('Logs.content'); ?></th>

            </tr>
            <tbody>
            <?php
            foreach ($logContent as $key => $log): ?>
                <tr <?php if (array_key_exists('extra', $log)) : ?> style="cursor:pointer"
                    data-bs-toggle="collapse" data-bs-target="#stack<?= $key ?>" aria-controls="stack<?= $key ?>" aria-expanded="false"
                    <?php endif ?>
                >
                    <td class="text-<?= $log['class']; ?>">
                        <span class="<?= $log['icon']; ?>" aria-hidden="true"></span>
                        &nbsp;<?= $log['level'] ?>
                    </td>
                    <td class="date"><?= app_date($log['date'], true) ?></td>
                    <td class="text">
                        <?= esc($log['content']) ?>
                        <?= (array_key_exists('extra', $log)) ? '...' : ''; ?>
                    </td>
                </tr>

                <?php
                if (array_key_exists('extra', $log)): ?>

                    <tr class="collapse bg-light" id="stack<?= $key ?>">
                        <td colspan="3">
                            <pre class="text-wrap">
                                <?= nl2br(trim(esc($log['extra']), " \n")) ?>
                            </pre>
                        </td>
                    </tr>
                <?php
                endif; ?>
            <?php
            endforeach; ?>
            </tbody>
        </table>

        <?= $pager->links() ?>

    </div>

    <?php if ($canDelete) : ?>

        <form action="<?= route_to('log-delete-file'); ?>" class='form-horizontal' method="post">
            <?= csrf_field() ?>

            <input type="hidden" name="checked[]" value="<?= $logFile; ?>"/>
            <input type="submit" name="delete" class="btn btn-danger btn-sm" value="<?= lang('Logs.delete_file'); ?>" onclick="return confirm('<?= lang('Logs.delete_confirm') ?>')"/>

        </form>

    <?php endif ?>
</x-admin-box>
</div>
<?php $this->endSection() ?>
