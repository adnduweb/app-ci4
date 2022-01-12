<div class="pb-5 fs-6">
    <!--begin::Details item-->
    <div class="fw-bolder mt-5">Account ID</div>
    <div class="text-gray-600">ID-<?= $form->uuid; ?></div>
    <!--begin::Details item-->
    <!--begin::Details item-->
    <div class="fw-bolder mt-5">Email</div>
    <div class="text-gray-600">
        <a href="mailto:<?= $form->email; ?>" class="text-gray-600 text-hover-primary"><?= $form->email; ?></a>
    </div>
    <!--begin::Details item-->
    <!--begin::Details item-->
    <div class="fw-bolder mt-5">Address</div>
    <div class="text-gray-600"><?= (!empty($form->users_adresses)) ? $form->users_adresses[0]->adresse1 .  ', <br>' : ''; ?>
    <?= (!empty($form->users_adresses)) ? $form->users_adresses[0]->code_postal : ''; ?> <?= (!empty($form->users_adresses)) ? $form->users_adresses[0]->ville . '<br>' : ''; ?>
    <?= $form->id_country; ?></div>
    <!--begin::Details item-->
    <!--begin::Details item-->
    <div class="fw-bolder mt-5">Language</div>
    <div class="text-gray-600"><?= $form->lang; ?></div>
    <!--begin::Details item-->
    <!--begin::Details item-->
    <div class="fw-bolder mt-5">Last Login</div>
    <div class="text-gray-600"><?= $form->last_login_at; ?> </div>
    <!--begin::Details item-->
</div>