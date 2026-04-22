<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Lista de users - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
    </head>
    <body>

        <?= $template->header('Lista de users') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs(['Users'=>null]) ?>
        <?= $template->messages() ?>

        <main>

            <h2>Lista completa de users</h2>
            <br>
            <?php
                echo $template->filter(
                    [
                        'Nombre' => 'displayname',
                        'Email' => 'email',
                    ],
                    [
                        'Nombre' => 'displayname',
                        'Email' => 'email',

                    ],
                    'Nombre',
                    'Nombre',
                    $filtro
                );?>
            <div class="right">
                <?= $paginator->stats() ?>
            </div>
            <?php if($users){ ?>
                <div class="grid-list">
                    <div class="grid-list-header">
                        <span>Imagen</span>
                        <span>Nombre</span>
                        <span>Email</span>
                        <span>Teléfono</span>
                        <span>Población</span>
                        <span>CP</span>
                        <span>Roles</span>
                        <span class="centrado">Operaciones</span>
                    </div>
                <?php foreach($users as $user){ ?>
                    <div class="grid-list-item">
                        <span data-label="Imagen" class="centrado">
                            <a href="/User/show/<?= $user->id ?>">
                                <img src="<?= USER_IMAGE_FOLDER . '/' .($user->picture ?? DEFAULT_USER_IMAGE) ?>" class="table-image">
                            </a>
                        </span>
                        <span data-label="Nombre"><?= $user->displayname ?></span>
                        <span data-label="Email"><?= $user->email ?></span>
                        <span data-label="Teléfono"><?= $user->phone ?></span>
                        <span data-label="Población"><?= $user->poblacion ?></span>
                        <span data-label="CP"><?= $user->cp ?></span>
                        <span data-label="Roles"><?= implode(", ", $user->roles) ?></span>
                        <span data-label="Operaciones" class="centrado">
                            <a href="/User/show/<?= $user->id ?>">Ver</a>
                            <a href="/User/edit/<?= $user->id ?>">Editar</a>
                            <a href="/User/delete/<?= $user->id ?>">Borrar</a>
                             <?php if( in_array('ROLE_BLOCKED', $user->getRoles()) ){ ?>
                                <a href="/User/unblock/<?= $user->id ?>">Desbloquear</a>
                            <?php } else {?>
                                <a href="/User/block/<?= $user->id ?>">Bloquear</a>
                            <?php } ?>
                        </span>
                    </div>
                <?php } ?>
                </div>
                <?= $paginator->ellipsisLinks() ?>
            <?php } else { ?>
                <div class="danger p2">
                    <p>No hay users que mostrar</p>
                </div>
            <?php } ?>
            <div class="centered">
                <a class="button-success flex1" href="/User/create">Nuevo user</a>
                <a class="button" onclick="history.back()">Atrás</a>
            </div>
        </main>
        <?= $template->footer() ?>
    </body>
</html>