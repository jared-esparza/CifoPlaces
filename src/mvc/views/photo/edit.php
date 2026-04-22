<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Editar foto - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <script src="/js/Preview.js"></script>
    </head>
    <body>

        <?= $template->header('Editar foto') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Lugares' => '/Place/list',
            $place->name => "/Place/show/$place->id",
            'Edición de '.$photo->name => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <h1><?= APP_NAME ?></h1>
            <h2>Editar la foto <?= $photo->name ?></h2>

            <form action="/Photo/update" enctype="multipart/form-data" method="POST" class="flex2 no-border">
                <div class="flex2">
                    <input type="hidden" name="id" value="<?= $photo->id ?>">
                    <input type="hidden" name="idplace" value="<?= $place->id ?>">

                    <label>Título:</label>
                    <input type="text" name="name" value="<?= old('name') ?: $photo->name ?>">
                    <br>

                    <label>Texto alternativo:</label>
                    <input type="text" name="alt" value="<?= old('alt') ?: $photo->alt ?>">
                    <br>

                    <label>Fecha:</label>
                    <input type="date" name="date" value="<?= old('date') ?: $photo->date ?>">
                    <br>

                    <label>Hora:</label>
                    <input type="time" name="time" value="<?= old('time') ?: $photo->time ?>">
                    <br>

                    <label>Imagen:</label>
                    <input type="file" name="file" id="file-with-preview" accept="image/*">
                    <br>

                    <label>Descripción:</label>
                    <textarea name="description" class="w50"><?= old('description') ?: $photo->description ?></textarea>
                    <br>

                    <div class="centered mt2">
                        <input type="submit" class="button" name="actualizar" value="Actualizar">
                        <input type="reset" class="button" value="Reset">
                    </div>
                </div>

                <figure class="flex1 centrado">
                    <img
                        src="<?= PHOTO_IMAGE_FOLDER.($photo->file ?: DEFAULT_PHOTO_IMAGE) ?>"
                        class="cover"
                        id="preview-image"
                        alt="<?= $photo->alt ?: $photo->name ?>"
                    >
                    <figcaption><?= $photo->name ?></figcaption>
                </figure>
            </form>

            <section>
                <h2>Comentarios de esta foto</h2>

                <?php if($comments): ?>
                    <div class="grid-list">
                        <div class="grid-list-header">
                            <span>Usuario</span>
                            <span>Comentario</span>
                            <span>Fecha</span>
                        </div>

                        <?php foreach($comments as $comment): ?>
                            <div class="grid-list-item">
                                <span data-label="Usuario"><?= $comment->username ?: 'Anónimo' ?></span>
                                <span data-label="Comentario"><?= toHTML($comment->text) ?></span>
                                <span data-label="Fecha"><?= $comment->created_at ?: '--' ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No hay comentarios todavía.</p>
                <?php endif; ?>
            </section>

            <div class="centrado my2">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/Photo/show/<?= $photo->id ?>">Detalles</a>
                <a class="button-danger" href="/Photo/delete/<?= $photo->id ?>">Borrar</a>
                <a class="button" href="/Place/show/<?= $place->id ?>">Volver al lugar</a>
            </div>
        </main>

        <?= $template->footer() ?>
    </body>
</html>