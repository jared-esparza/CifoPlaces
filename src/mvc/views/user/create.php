<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Nuevo user - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <script src="/js/Preview.js"></script>
    </head>
    <body>

        <?= $template->header('Borrar user') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Users'=>'/User/list',
            'Crear user' => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <h1><?= APP_NAME?></h1>

            <h2>Nuevo user</h2>

            <form action="/User/store" enctype="multipart/form-data" method="POST">
                <div class="flex2">
                    <label>Nombre:</label>
                    <input type="text" name="displayname" value="<?= old('displayname')?>">
                    <br>
                    <label>Email:</label>
                    <input type="email" name="email" value="<?= old('email')?>">
                    <br>
                    <label>Contraseña:</label>
                    <input type="password" name="password" value="<?= old('password')?>">
                    <br>
                    <label>Teléfono:</label>
                    <input type="text" name="phone" value="<?= old('phone')?>">
                    <br>
                    <label>Imagen:</label>
                    <input type="file" name="picture" id="file-with-preview" accept="image/*">
                </div>
                <div class="centered mt2">
                    <input type="submit" class="button" name="guardar" value="Guardar">
                    <input type="reset" class="button" value="Reset">
                </div>
                <figure class="flex1 centrado">
                    <img src="<?= USER_IMAGE_FOLDER . '/' .($user->imagen ?? DEFAULT_USER_IMAGE) ?>" class="cover" id="preview-image">
                    <figcaption>Previsualización de la imagen</figcaption>
                </figure>
            </form>
            <div class="centrado my2">
                <a class="button" onclick="history.back()">Atras</a>
                <a class="button" href="/user/list">Lista de users</a>
            </div>
        </main>
        <?= $template->footer() ?>
    </body>
</html>