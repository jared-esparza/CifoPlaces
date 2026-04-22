<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Borrar de user - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
    </head>
    <body>

        <?= $template->header('Borrar user') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Users'=>'/User/list',
            'Borrado ' . $user->titulo => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <h1><?= APP_NAME?></h1>

            <h2>Borrar user</h2>

            <form action="/User/destroy" enctype="multipart/form-data" method="POST" class="p2 m2">
                <p>Confirmar el borrado del user<?= $user->displayname ?></p>
                <input type="hidden" name="id" value="<?= $user->id ?>">
                <input type="submit" class="button-danger" name="borrar" value="Borrar">
            </form>
            <div class="centrado my2">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/user/list">Lista de users</a>
                <a class="button" href="/user/show/<?= $user->id ?>">Detalles</a>
                <a class="button" href="/user/edit/<?= $user->id ?>">Editar</a>
            </div>
        </main>
        <?= $template->footer() ?>
    </body>
</html>