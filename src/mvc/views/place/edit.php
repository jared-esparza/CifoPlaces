<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Editar lugar - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <script src="/js/Preview.js"></script>
    </head>
    <body>

        <?= $template->header('Editar lugar') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Lugares' => '/Place/list',
            'Edición ' . $place->name => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <h1><?= APP_NAME ?></h1>
            <h2>Editar el lugar <?= $place->name ?></h2>

            <form action="/Place/update" enctype="multipart/form-data" method="POST" class="flex2 no-border">
                <div class="flex2">
                    <input type="hidden" value="<?= $place->id ?>" name="id">

                    <label>Nombre:</label>
                    <input type="text" name="name" value="<?= old('name', $place->name) ?>">
                    <br>

                    <label>Tipo:</label>
                    <input type="text" name="type" value="<?= old('type', $place->type) ?>">
                    <br>

                    <label>Localización:</label>
                    <input type="text" name="location" value="<?= old('location', $place->location) ?>">
                    <br>

                    <label>Latitud:</label>
                    <input type="text" name="latitude" value="<?= old('latitude', $place->latitude) ?>">
                    <br>

                    <label>Longitud:</label>
                    <input type="text" name="longitude" value="<?= old('longitude', $place->longitude) ?>">
                    <br>

                    <label>Imagen principal:</label>
                    <input type="file" name="mainpicture" id="file-with-preview" accept="image/*">
                    <br>

                    <label>Descripción:</label>
                    <textarea name="description" class="w50"><?= old('description', $place->description) ?></textarea>
                    <br>

                    <div class="centered mt2">
                        <input type="submit" class="button" name="actualizar" value="Actualizar">
                        <input type="reset" class="button" value="Reset">
                    </div>
                </div>

                <figure class="flex1 centrado">
                    <img
                        src="<?= PLACE_IMAGE_FOLDER.($place->mainpicture ?: DEFAULT_PLACE_IMAGE) ?>"
                        class="cover"
                        id="preview-image"
                        alt="<?= $place->name ?>"
                    >
                    <figcaption>Imagen principal de <?= $place->name ?></figcaption>
                </figure>
            </form>

            <section>
                <h2>Fotos de este lugar</h2>

                <?php if(Photo::canCreate()): ?>
                    <a class="button" href="/Photo/create/<?= $place->id ?>">Nueva foto</a>
                <?php endif; ?>

                <?php if($pictures): ?>
                    <div class="grid-list">
                        <div class="grid-list-header">
                            <span>Imagen</span>
                            <span>Título</span>
                            <span>Usuario</span>
                            <span>Fecha</span>
                            <span class="centrado">Operaciones</span>
                        </div>

                        <?php foreach($pictures as $picture): ?>
                            <div class="grid-list-item">
                                <span data-label="Imagen" class="centrado">
                                    <a href="/Photo/show/<?= $picture->id ?>">
                                        <img
                                            src="/uploads/photos/<?= $picture->file ?: 'default-photo.jpg' ?>"
                                            class="table-image"
                                            alt="<?= $picture->alt ?: $picture->name ?>"
                                        >
                                    </a>
                                </span>

                                <span data-label="Título"><?= $picture->name ?></span>
                                <span data-label="Usuario"><?= $picture->username ?: 'Anónimo' ?></span>
                                <span data-label="Fecha"><?= $picture->date ?: '--' ?></span>

                                <span data-label="Operaciones" class="centrado">
                                    <a href="/Photo/show/<?= $picture->id ?>">Ver</a>
                                    | <a href="/Photo/edit/<?= $picture->id ?>">Editar</a>
                                    | <a href="/Photo/delete/<?= $picture->id ?>">Borrar</a>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No hay fotos para este lugar.</p>
                <?php endif; ?>
            </section>

            <section>
                <h2>Comentarios de este lugar</h2>

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
                <a class="button" href="/Place/show/<?= $place->id ?>">Detalles</a>
                <a class="button-danger" href="/Place/delete/<?= $place->id ?>">Borrar</a>
                <a class="button" href="/Place/list">Lista de lugares</a>
            </div>
        </main>

        <?= $template->footer() ?>
    </body>
</html>