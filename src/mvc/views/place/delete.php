<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Borrar lugar - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
    </head>
    <body>

        <?= $template->header('Borrar lugar') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Lugares' => '/Place/list',
            'Borrado ' . $place->name => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <h1><?= APP_NAME ?></h1>
            <h2>Borrar lugar</h2>

            <form action="/Place/destroy" enctype="multipart/form-data" method="POST" class="p2 m2">
                <p>Confirmar el borrado del lugar <?= $place->name ?></p>
                <input type="hidden" name="id" value="<?= $place->id ?>">
                <input type="submit" class="button-danger" name="borrar" value="Borrar">
            </form>

            <div class="centrado my2">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/Place/list">Lista de lugares</a>
                <a class="button" href="/Place/show/<?= $place->id ?>">Detalles</a>
                <a class="button" href="/Place/edit/<?= $place->id ?>">Editar</a>
            </div>
        </main>

        <?= $template->footer() ?>
    </body>
</html>