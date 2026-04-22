<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Editar user - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <script src="/js/Preview.js"></script>
    </head>
    <body>

        <?= $template->header('Editar user') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Users'=>'/User/list',
            'Edición ' . $user->displayname => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <h1><?= APP_NAME?></h1>

            <h2>Editar el user <?= $user->displayname ?></h2>

            <form action="/User/update" enctype="multipart/form-data" method="POST" class="flex2 no-border">
                <div class="flex2">
                    <input type="hidden" value="<?= $user->id ?>" name="id">
                    <label>Nombre:</label>
                    <input type="text" name="displayname" value="<?= old('displayname', $user->displayname)?>">
                    <br>
                    <label>Email:</label>
                    <input type="email" name="email" value="<?= old('email', $user->email)?>">
                    <br>
                    <label>Teléfono:</label>
                    <input type="text" name="phone" value="<?= old('phone', $user->phone)?>">
                    <br>
                    <label>Imagen:</label>
                    <input type="file" name="picture" id="file-with-preview" accept="image/*">
                    <div class="centered mt2">
                        <input type="submit" class="button" name="actualizar" value="Actualizar">
                        <input type="reset" class="button" value="Reset">
                    </div>
                </div>
            </form>
            <figure class="flex1 centrado">
                <img src="<?= USER_IMAGE_FOLDER . '/' .($user->picture ?? DEFAULT_USER_IMAGE) ?>" class="cover" id="preview-image">
                <figcaption>Imagen de <?= $user->displayname ?></figcaption>
            <?php if($user->picture){ ?>
                <form action="/User/dropcover" method="POST" class="no-border">
                    <input type="hidden" name="id" value="<?= $user->id ?>">
                    <input type="submit" value="Eliminar imagen" name="borrar" class="button-danger">
                </form>
            <?php } ?>

            </figure>
            <div class="centrado my2">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/user/list">Lista de users</a>
                <a class="button" href="/user/show/<?= $user->id ?>">Detalles</a>
                <a class="button" href="/user/delete/<?= $user->id ?>">Borrar</a>
            </div>
        </main>
        <?= $template->footer() ?>
    </body>
</html>