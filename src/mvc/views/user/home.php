<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
    <head>
        <?= $template->metaData(
            'Mi espacio personal',
            'Espacio personal del usuario en '.APP_NAME
        ) ?>
        <?= $template->css() ?>
    </head>

    <body>
        <?= $template->menu() ?>
        <?= $template->header(null, 'Mi espacio personal') ?>
        <?= $template->breadCrumbs(['Mi espacio personal' => null]) ?>
        <?= $template->messages() ?>

        <main>
            <h1>Mi espacio personal</h1>

            <section class="flex-container gap2">
                <div class="flex3">
                    <h2><?= $user->displayname ?></h2>
                    <p><b>Email:</b> <?= $user->email ?></p>
                    <p><b>Teléfono:</b> <?= $user->phone ?: '--' ?></p>
                    <p><b>Roles:</b> <?= is_array($user->roles) ? implode(', ', $user->roles) : $user->roles ?></p>

                    <div class="my2">
                        <?php if(Place::canCreate()): ?>
                            <a class="button" href="/Place/create">Nuevo lugar</a>
                        <?php endif; ?>

                        <?php if(Photo::canCreate()): ?>
                            <a class="button" href="/Place/list">Subir foto a un lugar</a>
                        <?php endif; ?>
                    </div>
                </div>

                <figure class="flex1 pc centered">
                    <img
                        src="<?= USER_IMAGE_FOLDER.'/'.($user->picture ?: DEFAULT_USER_IMAGE) ?>"
                        alt="<?= $user->displayname ?>"
                        class="cover"
                    >
                    <figcaption><?= $user->displayname ?></figcaption>
                </figure>
            </section>

            <section>
                <h2>Mis lugares</h2>

                <?php if($places): ?>
                    <div class="grid-list">
                        <div class="grid-list-header">
                            <span>Portada</span>
                            <span>Nombre</span>
                            <span>Tipo</span>
                            <span>Localización</span>
                            <span class="centrado">Operaciones</span>
                        </div>

                        <?php foreach($places as $place): ?>
                            <div class="grid-list-item">
                                <span data-label="Portada" class="centrado">
                                    <a href="/Place/show/<?= $place->id ?>">
                                        <img
                                            src="<?= PLACE_IMAGE_FOLDER.($place->mainpicture ?: DEFAULT_PLACE_IMAGE) ?>"
                                            class="table-image"
                                            alt="<?= $place->name ?>"
                                        >
                                    </a>
                                </span>

                                <span data-label="Nombre"><?= $place->name ?></span>
                                <span data-label="Tipo"><?= $place->type ?: '--' ?></span>
                                <span data-label="Localización"><?= $place->location ?: '--' ?></span>

                                <span data-label="Operaciones" class="centrado">
                                    <a href="/Place/show/<?= $place->id ?>">Ver</a>

                                    <?php if($place->canEdit()): ?>
                                        | <a href="/Place/edit/<?= $place->id ?>">Editar</a>
                                    <?php endif; ?>

                                    <?php if($place->canDelete()): ?>
                                        | <a href="/Place/delete/<?= $place->id ?>">Borrar</a>
                                    <?php endif; ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>Todavía no has creado lugares.</p>
                <?php endif; ?>
            </section>

            <section>
                <h2>Mis fotos</h2>

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
                                            src="<?= PHOTO_IMAGE_FOLDER.($photo->file ?: DEFAULT_PHOTO_IMAGE) ?>"
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

                                    <?php if($photo->canEdit()): ?>
                                        | <a href="/Photo/edit/<?= $photo->id ?>">Editar</a>
                                    <?php endif; ?>

                                    <?php if($photo->canDelete()): ?>
                                        | <a href="/Photo/delete/<?= $photo->id ?>">Borrar</a>
                                    <?php endif; ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>Todavía no has subido fotos.</p>
                <?php endif; ?>
            </section>

            <section>
                <h2>Mis comentarios</h2>

                <?php if($comments): ?>
                    <div class="grid-list">
                        <div class="grid-list-header">
                            <span>Comentario</span>
                            <span>Sobre</span>
                            <span>Fecha</span>
                            <span class="centrado">Operaciones</span>
                        </div>

                        <?php foreach($comments as $comment): ?>
                            <?php
                                $place = $comment->place();
                                $photo = $comment->photo();
                            ?>
                            <div class="grid-list-item">
                                <span data-label="Comentario"><?= toHTML($comment->text) ?></span>

                                <span data-label="Sobre">
                                    <?php if($place): ?>
                                        Lugar:
                                        <a href="/Place/show/<?= $place->id ?>">
                                            <?= $place->name ?>
                                        </a>
                                    <?php elseif($photo): ?>
                                        Foto:
                                        <a href="/Photo/show/<?= $photo->id ?>">
                                            <?= $photo->name ?>
                                        </a>
                                    <?php else: ?>
                                        --
                                    <?php endif; ?>
                                </span>

                                <span data-label="Fecha"><?= $comment->created_at ?: '--' ?></span>

                                <span data-label="Operaciones" class="centrado">
                                    <?php if($comment->canDelete()): ?>
                                        <a href="/Comment/delete/<?= $comment->id ?>">Borrar</a>
                                    <?php else: ?>
                                        --
                                    <?php endif; ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>Todavía no has hecho comentarios.</p>
                <?php endif; ?>
            </section>
        </main>

        <?= $template->footer() ?>
        <?= $template->version() ?>
    </body>
</html>