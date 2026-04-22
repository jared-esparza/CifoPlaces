<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Detalles de users - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <script src="/js/Modal.js"></script>

    </head>
    <body>

        <?= $template->header('Detalle de ' . $user->displayname) ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Users'=>'/User/list',
            'Detalles de ' . $user->displayname => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <section class="flex-container gap2" id="detalles">
                <div class="flex2">
                    <h2><?= $user->displplayname?></h2>
                    <p><b>Email:</b> <?= $user->email?></p>
                    <p><b>Teléfono:</b> <?= $user->phone?></p>
                </div>
                <figure class="flex1 centrado p2">
                    <img src="<?= USER_IMAGE_FOLDER . '/' .($user->picture ?? DEFAULT_USER_IMAGE) ?>" class="cover with-modal">
                    <figcaption>Imagen de <?= "$user->displayname" ?></figcaption>
                </figure>
            </section>
            <div class="centrado">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/User/list">Lista de users</a>
                <?php if(Login::user() && Login::user()->id == $user->iduser){ ?>
                    <a class="button" href="/User/edit/<?=$user->id?>">Editar</a>
                    <a class="button" href="/User/delete/<?=$user->id?>">Eliminar</a>
                <?php } ?>
            </div>
        </main>
        <?= $template->footer() ?>
    </body>
</html>