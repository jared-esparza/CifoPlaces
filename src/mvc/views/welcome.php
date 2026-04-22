<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
    <head>
        <?= $template->metaData(
            "Portada de ".APP_NAME,
            "Red social de lugares y fotos"
        ) ?>
        <?= $template->css() ?>
        <script src="/js/Modal.js"></script>
    </head>

    <body>
        <?= $template->menu() ?>
        <?= $template->header("CIFOPlaces", "Red social de lugares y fotos") ?>
        <?= $template->messages() ?>
        <?= $template->acceptCookies() ?>

        <main>
            <section class="flex-container gap2">
                <div class="flex2">
                    <h1>Descubre lugares. Comparte experiencias.</h1>

                    <p>
                        <b>CIFOPlaces</b> es una red social de lugares donde puedes
                        descubrir sitios interesantes, compartir tus fotos y dejar
                        comentarios sobre cada experiencia.
                    </p>

                    <p>
                        Explora nuevos rincones, publica tus lugares favoritos y
                        participa en la comunidad con imágenes y opiniones.
                    </p>

                    <div class="my2">
                        <a class="button" href="/Place/list">Ver lugares</a>

                        <?php if(Place::canCreate()): ?>
                            <a class="button" href="/Place/create">Publicar un lugar</a>
                        <?php endif; ?>

                        <?php if(Login::user()): ?>
                            <a class="button-light" href="/User/home">Mi espacio personal</a>
                        <?php endif; ?>
                    </div>
                </div>

                <figure class="card flex1 centered">
                    <?php if($places): ?>
                        <?php $cover = $places[0]; ?>
                        <a href="/Place/show/<?= $cover->id ?>">
                            <img
                                class="landscape cover with-modal"
                                src="<?= PLACE_IMAGE_FOLDER.($cover->mainpicture ?: DEFAULT_PLACE_IMAGE) ?>"
                                alt="<?= $cover->name ?>"
                                title="<?= $cover->name ?>"
                            >
                        </a>
                        <figcaption>
                            Último lugar publicado: <b><?= $cover->name ?></b>
                        </figcaption>
                    <?php else: ?>
                        <img
                            class="landscape cover"
                            src="<?= PLACE_IMAGE_FOLDER.DEFAULT_PLACE_IMAGE ?>"
                            alt="CIFOPlaces"
                            title="CIFOPlaces"
                        >
                        <figcaption>Empieza a compartir lugares</figcaption>
                    <?php endif; ?>
                </figure>
            </section>

            <section>
                <h2>Qué puedes hacer en CIFOPlaces</h2>

                <div class="flex-container gap2">
                    <section class="flex1">
                        <h3>Explorar</h3>
                        <p>
                            Consulta los lugares publicados, entra en sus detalles y
                            descubre nuevas ubicaciones.
                        </p>
                    </section>

                    <section class="flex1">
                        <h3>Compartir</h3>
                        <p>
                            Publica nuevos lugares y añade fotos para mostrar tu visión
                            de cada sitio.
                        </p>
                    </section>

                    <section class="flex1">
                        <h3>Comentar</h3>
                        <p>
                            Participa dejando comentarios en lugares y fotos para
                            enriquecer la experiencia de la comunidad.
                        </p>
                    </section>
                </div>
            </section>

            <section>
                <h2>Últimos lugares publicados</h2>

                <?php if($places): ?>
                    <div class="gallery">
                        <?php foreach($places as $place): ?>
                            <figure class="card medium">
                                <a href="/Place/show/<?= $place->id ?>">
                                    <img
                                        class="square cover with-modal"
                                        src="<?= PLACE_IMAGE_FOLDER.($place->mainpicture ?: DEFAULT_PLACE_IMAGE) ?>"
                                        alt="<?= $place->name ?>"
                                        title="<?= $place->name ?>"
                                    >
                                </a>

                                <figcaption class="left">
                                    <p><b><?= $place->name ?></b></p>
                                    <p><?= $place->type ?: 'Sin tipo' ?></p>
                                    <p><?= $place->location ?: 'Sin localización' ?></p>
                                    <p class="mini">Por: <?= $place->username ?: 'Anónimo' ?></p>

                                    <div class="mt2 centered">
                                        <a class="button" href="/Place/show/<?= $place->id ?>">Ver lugar</a>
                                    </div>
                                </figcaption>
                            </figure>
                        <?php endforeach; ?>
                    </div>

                    <div class="centrado my2">
                        <a class="button-light" href="/Place/list">Ver todos los lugares</a>
                    </div>
                <?php else: ?>
                    <p>Todavía no hay lugares publicados.</p>

                    <?php if(Place::canCreate()): ?>
                        <div class="centrado my2">
                            <a class="button" href="/Place/create">Crear el primer lugar</a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </section>
        </main>

        <?= $template->footer() ?>
        <?= $template->version() ?>
    </body>
</html>