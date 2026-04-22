<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Nuevo lugar - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <script src="/js/Preview.js"></script>
    </head>
    <body>

        <?= $template->header('Nuevo lugar') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Lugares' => '/Place/list',
            'Crear lugar' => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <h1><?= APP_NAME ?></h1>
            <h2>Nuevo lugar</h2>

            <form action="/Place/store" enctype="multipart/form-data" method="POST">
                <div class="flex2">
                    <div class="flex2">
                        <label>Nombre:</label>
                        <input type="text" name="name" value="<?= old('name') ?>">
                        <br>

                        <label>Tipo:</label>
                        <input type="text" name="type" value="<?= old('type') ?>">
                        <br>

                        <label>Localización:</label>
                        <input type="text" name="location" value="<?= old('location') ?>">
                        <br>

                        <label>Latitud:</label>
                        <input type="text" name="latitude" value="<?= old('latitude') ?>">
                        <br>

                        <label>Longitud:</label>
                        <input type="text" name="longitude" value="<?= old('longitude') ?>">
                        <br>

                        <label>Imagen principal:</label>
                        <input type="file" name="mainpicture" id="file-with-preview" accept="image/*">
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
                        <img src="<?= PLACE_IMAGE_FOLDER.DEFAULT_PLACE_IMAGE ?>" class="cover" id="preview-image">
                        <figcaption>Previsualización de la imagen principal</figcaption>
                    </figure>
                </div>
            </form>

            <div class="centrado my2">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/Place/list">Lista de lugares</a>
            </div>
        </main>

        <?= $template->footer() ?>
    </body>
</html>