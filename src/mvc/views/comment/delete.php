<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Borrar comentario - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
    </head>
    <body>

        <?= $template->header('Borrar comentario') ?>
        <?= $template->menu() ?>
        <?= $template->messages() ?>

        <main>
            <h1><?= APP_NAME ?></h1>
            <h2>Confirmar borrado del comentario</h2>

            <section>
                <p><b>Autor:</b> <?= $author ? $author->displayname : 'Anónimo' ?></p>

                <?php if($place): ?>
                    <p><b>Lugar:</b> <?= $place->name ?></p>
                <?php endif; ?>

                <?php if($photo): ?>
                    <p><b>Foto:</b> <?= $photo->name ?></p>
                <?php endif; ?>

                <p><b>Comentario:</b></p>
                <p><?= toHTML($comment->text) ?></p>
            </section>

            <form action="/Comment/destroy" method="POST" class="p2 m2">
                <input type="hidden" name="id" value="<?= $comment->id ?>">
                <input type="submit" class="button-danger" name="borrar" value="Borrar">
            </form>

            <div class="centrado my2">
                <a class="button" onclick="history.back()">Cancelar</a>

                <?php if($place): ?>
                    <a class="button" href="/Place/show/<?= $place->id ?>">Volver al lugar</a>
                <?php endif; ?>

                <?php if($photo): ?>
                    <a class="button" href="/Photo/show/<?= $photo->id ?>">Volver a la foto</a>
                <?php endif; ?>
            </div>
        </main>

        <?= $template->footer() ?>
    </body>
</html>