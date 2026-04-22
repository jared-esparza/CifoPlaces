<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Borrar foto - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
    </head>
    <body>

        <?= $template->header('Borrar foto') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Lugares' => '/Place/list',
            $place->name => "/Place/show/$place->id",
            'Borrar foto' => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <h1><?= APP_NAME ?></h1>
            <h2>Borrar foto</h2>

            <section class="flex-container gap2">
                <div class="flex2">
                    <p><b>Título:</b> <?= $photo->name ?></p>
                    <p><b>Lugar:</b> <?= $place->name ?></p>
                    <p><b>Fecha:</b> <?= $photo->date ?: '--' ?></p>
                    <p><b>Hora:</b> <?= $photo->time ?: '--' ?></p>
                    <p><b>Descripción:</b> <?= $photo->description ? toHTML($photo->description) : 'Sin descripción.' ?></p>

                    <form action="/Photo/destroy" method="POST" class="p2 m2">
                        <input type="hidden" name="id" value="<?= $photo->id ?>">
                        <p>Confirmar el borrado de la foto <?= $photo->name ?></p>
                        <input type="submit" class="button-danger" name="borrar" value="Borrar">
                    </form>
                </div>

                <figure class="flex1 centrado">
                    <img
                        src="<?= PHOTO_IMAGE_FOLDER.($photo->file ?: DEFAULT_PHOTO_IMAGE) ?>"
                        class="cover"
                        alt="<?= $photo->alt ?: $photo->name ?>"
                    >
                    <figcaption><?= $photo->name ?></figcaption>
                </figure>
            </section>

            <div class="centrado my2">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/Photo/show/<?= $photo->id ?>">Detalles</a>
                <a class="button" href="/Place/show/<?= $place->id ?>">Volver al lugar</a>
            </div>
        </main>

        <?= $template->footer() ?>
    </body>
</html>