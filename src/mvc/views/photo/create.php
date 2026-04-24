<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Nueva foto - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <script src="/js/Preview.js"></script>
    </head>
    <body>

        <?= $template->header('Nueva foto') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Lugares' => '/Place/list',
            $place->name => "/Place/show/$place->id",
            'Nueva foto' => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <h1><?= APP_NAME ?></h1>
            <h2>Nueva foto para <?= $place->name ?></h2>

            <form action="/Photo/store" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="idplace" value="<?= $place->id ?>">

                <div class="flex2">
                    <div class="flex2">
                        <label>Título:</label>
                        <input type="text" name="name" value="<?= old('name') ?>">
                        <br>

                        <label>Texto alternativo:</label>
                        <input type="text" name="alt" value="<?= old('alt') ?>">
                        <br>

                        <label>Fecha:</label>
                        <input type="date" name="date" value="<?= old('date') ?>">
                        <br>

                        <label>Hora:</label>
                        <input type="time" name="time" value="<?= old('time') ?>">
                        <br>

                        <label>Imagen:</label>
                        <input type="file" name="file" id="file-with-preview" accept="image/*" required>
                        <br>

                        <label>Descripción:</label>
                        <textarea name="description" class="w50"><?= old('description') ?></textarea>
                        <br>

                        <div class="centered mt2">
                            <input type="submit" class="button" name="guardar" value="Guardar">
                            <input type="reset" class="button" value="Reset">
                        </div>
                    </div>

                    <figure class="flex1 centrado">
                        <img src="<?= PHOTO_IMAGE_FOLDER.DEFAULT_PHOTO_IMAGE ?>" class="cover" id="preview-image">
                        <figcaption>Previsualización de la foto</figcaption>
                    </figure>
                </div>
            </form>

            <div class="centrado my2">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/Place/show/<?= $place->id ?>">Volver al lugar</a>
            </div>
        </main>

        <?= $template->footer() ?>
    </body>
</html>