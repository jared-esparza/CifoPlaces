<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Lista de lugares - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
    </head>
    <body>

        <?= $template->header('Lista de lugares') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs(['Lugares' => null]) ?>
        <?= $template->messages() ?>

        <main>
            <h1><?= APP_NAME ?></h1>
            <h2>Lista completa de lugares</h2>
            <br>

            <?php
                echo $template->filter(
                    [
                        'Nombre' => 'name',
                        'Tipo' => 'type',
                        'Localización' => 'location',
                        'Descripción' => 'description',
                        'Usuario' => 'username'
                    ],
                    [
                        'Nombre' => 'name',
                        'Tipo' => 'type',
                        'Localización' => 'location',
                        'Fecha creación' => 'created_at'
                    ],
                    'Nombre',
                    'Nombre',
                    $filtro
                );
            ?>

            <div class="right">
                <?= $paginator->stats() ?>
            </div>

            <?php if(Place::canCreate()): ?>
                <div class="right my2">
                    <a class="button" href="/Place/create">Nuevo lugar</a>
                </div>
            <?php endif; ?>

            <?php if($places): ?>
                <div class="grid-list">
                    <div class="grid-list-header">
                        <span>Portada</span>
                        <span>Nombre</span>
                        <span>Tipo</span>
                        <span>Localización</span>
                        <span>Usuario</span>
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
                            <span data-label="Usuario"><?= $place->username ?: 'Anónimo' ?></span>

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

                <div class="centered">
                    <?= $paginator->ellipsisLinks() ?>
                </div>
            <?php else: ?>
                <p>No hay lugares que mostrar.</p>
            <?php endif; ?>

            <div class="centrado my2">
                <a class="button" onclick="history.back()">Atrás</a>
            </div>
        </main>

        <?= $template->footer() ?>
    </body>
</html>