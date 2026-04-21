<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
                "Portada del sitio",
                "Página de inicio del framework PHP FastLight"
        ) ?>
        <?= $template->css() ?>

		<!-- JS -->
		<script src="/js/TextReader.js"></script>
		<script src="/js/Modal.js"></script>
	</head>

	<body>
		<?= $template->menu() ?>
		<?= $template->header("CifoPlaces", 'Red social de lugares y fotos') ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>

		<main>
    		<h1>Bienvenido</h1>

    		<section id="queesfastlight"  class="flex-container gap2">
				<div class="flex2">
          			<h2>Bienvenido a CifoPlaces</h2>

            		<p>Está <b>pensado para docencia</b>, con lo que incorpora las
        		   	 características  esenciales para desarrollo de una aplicación web rápida, sólida y fiable, pero no
        			  incluye algunas funcionalidades complejas que desarrollamos en clase (pero que encontraréis en la documentación). </p>
    		    </div>

    		    <figure class="flex1 medium centered centered-block">
    		    	<img class="square fit with-modal" src="/images/template/phpmysql.png"
    		    		 alt="FastLight recomienda PHP8.2 y MySQL8"
    		    		 title="FastLight recomienda PHP8.2 y MySQL8"
    		    		 data-caption="La combinación perfecta"
    		    		 data-description="Se recomienda PHP8.2 y MySQL8"
    		    	>
    		    </figure>
		    </section>
		</main>

		<?= $template->footer() ?>
		<?= $template->version() ?>

	</body>
</html>

