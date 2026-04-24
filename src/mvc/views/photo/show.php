<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Detalle de la foto - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <script src="/js/Modal.js"></script>
    </head>
    <body>

        <?= $template->header('Detalle de la foto') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Lugares' => '/Place/list',
            $place->name => "/Place/show/$place->id",
            $photo->name => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <section class="flex-container gap2" id="detalles">
                <div class="flex2">
                    <h2><?= $photo->name ?></h2>
                    <p><b>Título:</b> <?= $photo->name ?></p>
                    <p><b>Texto alternativo:</b> <?= $photo->alt ?: '--' ?></p>
                    <p><b>Fecha:</b> <?= $photo->date ?: '--' ?></p>
                    <p><b>Hora:</b> <?= $photo->time ?: '--' ?></p>
                    <p><b>Lugar:</b> <a href="/Place/show/<?= $place->id ?>"><?= $place->name ?></a></p>

                    <?php $author = $photo->author(); ?>
                    <p><b>Usuario:</b> <?= $author ? $author->displayname : 'Anónimo' ?></p>

                    <p><b>Creada:</b> <?= $photo->created_at ?: '--' ?></p>
                </div>

                <figure class="flex1 centrado p2">
                    <img
                        src="<?= PHOTO_IMAGE_FOLDER.($photo->file ?: DEFAULT_PHOTO_IMAGE) ?>"
                        class="cover with-modal"
                        alt="<?= $photo->alt ?: $photo->name ?>"
                    >
                    <figcaption><?= $photo->name ?></figcaption>
                </figure>
            </section>

            <section>
                <h2>Descripción</h2>
                <p><?= $photo->description ? toHTML($photo->description) : 'Sin descripción.' ?></p>
            </section>

            <section>
                <h2>Operaciones</h2>

                <?php if($photo->canEdit()): ?>
                    <a class="button" href="/Photo/edit/<?= $photo->id ?>">Editar foto</a>
                <?php endif; ?>

                <?php if($photo->canDelete()): ?>
                    <a class="button-danger" href="/Photo/delete/<?= $photo->id ?>">Borrar foto</a>
                <?php endif; ?>

                <?php if(Photo::canCreate()): ?>
                    <a class="button" href="/Photo/create/<?= $place->id ?>">Nueva foto</a>
                <?php endif; ?>
            </section>

            <section>
                <h2>Comentarios de esta foto</h2>

                <?php if(Login::user()): ?>
                    <form action="/Comment/store" method="POST" class="p2 m2">
                        <input type="hidden" name="idplace" value="">
                        <input type="hidden" name="idphoto" value="<?= $photo->id ?>">

                        <label>Nuevo comentario:</label>
                        <textarea name="text" class="w100"></textarea>
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
                <a class="button" href="/Place/show/<?= $place->id ?>">Volver al lugar</a>
            </div>
        </main>

        <?= $template->footer() ?>
    </body>
</html>