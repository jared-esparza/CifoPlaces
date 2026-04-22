<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Detalle del lugar - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <script src="/js/Modal.js"></script>
    </head>
    <body>

        <?= $template->header('Detalle de ' . $place->name) ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Lugares' => '/Place/list',
            'Detalles de ' . $place->name => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <section class="flex-container gap2" id="detalles">
                <div class="flex2">
                    <h2><?= $place->name ?></h2>
                    <p><b>Nombre:</b> <?= $place->name ?></p>
                    <p><b>Tipo:</b> <?= $place->type ?: '--' ?></p>
                    <p><b>Localización:</b> <?= $place->location ?: '--' ?></p>
                    <p><b>Latitud:</b> <?= $place->latitude ?: '--' ?></p>
                    <p><b>Longitud:</b> <?= $place->longitude ?: '--' ?></p>

                    <?php $author = $place->author(); ?>
                    <p><b>Usuario creador:</b> <?= $author ? $author->displayname : 'Anónimo' ?></p>

                    <p><b>Creado:</b> <?= $place->created_at ?: '--' ?></p>
                </div>

                <figure class="flex1 centrado p2">
                    <img
                        src="<?= PLACE_IMAGE_FOLDER.($place->mainpicture ?: DEFAULT_PLACE_IMAGE) ?>"
                        class="cover with-modal"
                        alt="<?= $place->name ?>"
                    >
                    <figcaption>Imagen principal de <?= $place->name ?></figcaption>
                </figure>
            </section>

            <section>
                <h2>Descripción</h2>
                <p><?= $place->description ? toHTML($place->description) : 'Sin descripción.' ?></p>
            </section>

            <section>
                <h2>Operaciones</h2>

                <?php if($place->canEdit()): ?>
                    <a class="button" href="/Place/edit/<?= $place->id ?>">Editar lugar</a>
                <?php endif; ?>

                <?php if($place->canDelete()): ?>
                    <a class="button-danger" href="/Place/delete/<?= $place->id ?>">Borrar lugar</a>
                <?php endif; ?>

                <?php if(Photo::canCreate()): ?>
                    <a class="button" href="/Photo/create/<?= $place->id ?>">Nueva foto</a>
                <?php endif; ?>
            </section>

            <section>
                <h2>Fotos de este lugar</h2>

                <?php if($photos): ?>
                    <div class="grid-list">
                        <div class="grid-list-header">
                            <span>Imagen</span>
                            <span>Título</span>
                            <span>Fecha</span>
                            <span>Hora</span>
                            <span class="centrado">Operaciones</span>
                        </div>

                        <?php foreach($photos as $photo): ?>
                            <div class="grid-list-item">
                                <span data-label="Imagen" class="centrado">
                                    <a href="/Photo/show/<?= $photo->id ?>">
                                        <img
                                            src="/uploads/photos/<?= $photo->file ?: 'default-photo.jpg' ?>"
                                            class="table-image"
                                            alt="<?= $photo->alt ?: $photo->name ?>"
                                        >
                                    </a>
                                </span>

                                <span data-label="Título"><?= $photo->name ?></span>
                                <span data-label="Fecha"><?= $photo->date ?: '--' ?></span>
                                <span data-label="Hora"><?= $photo->time ?: '--' ?></span>

                                <span data-label="Operaciones" class="centrado">
                                    <a href="/Photo/show/<?= $photo->id ?>">Ver</a>

                                    <?php if(method_exists($photo, 'canEdit') && $photo->canEdit()): ?>
                                        | <a href="/Photo/edit/<?= $photo->id ?>">Editar</a>
                                    <?php endif; ?>

                                    <?php if(method_exists($photo, 'canDelete') && $photo->canDelete()): ?>
                                        | <a href="/Photo/delete/<?= $photo->id ?>">Borrar</a>
                                    <?php endif; ?>
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

                <?php if(Login::user()): ?>
                    <form action="/Comment/store" method="POST" class="p2 m2">
                        <input type="hidden" name="idplace" value="<?= $place->id ?>">
                        <input type="hidden" name="idphoto" value="">

                        <label>Nuevo comentario:</label>
                        <textarea name="text" class="w100"><?= old('text') ?></textarea>
                        <br>

                        <input type="submit" class="button" name="guardar" value="Comentar">
                    </form>
                <?php else: ?>
                    <p>Debes identificarte para comentar.</p>
                <?php endif; ?>

                <?php if($comments): ?>
                    <div class="grid-list">
                        <div class="grid-list-header">
                            <span>Usuario</span>
                            <span>Comentario</span>
                            <span>Fecha</span>
                            <span class="centrado">Operaciones</span>
                        </div>

                        <?php foreach($comments as $comment): ?>
                            <div class="grid-list-item">
                                <span data-label="Usuario"><?= $comment->username ?: 'Anónimo' ?></span>
                                <span data-label="Comentario"><?= toHTML($comment->text) ?></span>
                                <span data-label="Fecha"><?= $comment->created_at ?: '--' ?></span>
                                <span data-label="Operaciones" class="centrado">
                                    <?php if(method_exists($comment, 'canDelete') && $comment->canDelete()): ?>
                                        <a href="/Comment/delete/<?= $comment->id ?>">Borrar</a>
                                    <?php else: ?>
                                        --
                                    <?php endif; ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>Todavía no hay comentarios.</p>
                <?php endif; ?>
            </section>

            <div class="centrado my2">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/Place/list">Lista de lugares</a>
            </div>
        </main>

        <?= $template->footer() ?>
    </body>
</html>