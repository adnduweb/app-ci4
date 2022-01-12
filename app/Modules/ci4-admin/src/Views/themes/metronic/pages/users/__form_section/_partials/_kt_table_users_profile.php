<!--begin::Table body-->
<tbody class="fs-6 fw-bold text-gray-600">
    <tr>
        <td>Email</td>
        <td><?= $form->email; ?></td>
        <td class="text-end">
            <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_email">
                <?= service('theme')->getSVG('duotune/art/art005.svg', "svg-icon svg-icon-3"); ?>
            </button>
        </td>
    </tr>
    <tr>
        <td>Password</td>
        <td>******</td>
        <td class="text-end">
            <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_password">
                <?= service('theme')->getSVG('duotune/art/art005.svg', "svg-icon svg-icon-3"); ?>
            </button>
        </td>
    </tr>
    <tr>
        <td>Role</td>
        <td><?= ucfirst($form->auth_groups_users[0]->group->name); ?></td>
        <td class="text-end">
            <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
                <?= service('theme')->getSVG('duotune/art/art005.svg', "svg-icon svg-icon-3"); ?>
            </button>
        </td>
    </tr>
    <tr>
        <td>Phone</td>
        <td>
            <?= (!empty($form->users_adresses[0]->phone)) ? service('theme')->getSVG('icons/duotone/Devices/Headphones.svg', "svg-icon svg-icon-1") . '<a href="tel:' .trim($form->users_adresses[0]->phone) . '">' .$form->users_adresses[0]->phone . '</a> ' : 'nc'; ?>
            <?= (!empty($form->users_adresses[0]->phone_mobile)) ? '<br/>' . service('theme')->getSVG('icons/duotone/Devices/Phone.svg', "svg-icon svg-icon-1") . '<a href="tel:' .trim($form->users_adresses[0]->phone_mobile) . '">' .$form->users_adresses[0]->phone_mobile . '</a>' : 'nc'; ?>
        </td>
        <td class="text-end">
            <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_phone">
                <?= service('theme')->getSVG('duotune/art/art005.svg', "svg-icon svg-icon-3"); ?>
            </button>
        </td>
    </tr>
</tbody>
<!--end::Table body-->