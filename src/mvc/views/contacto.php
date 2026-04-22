<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
                "Contacto",
                "Pàgina de contacto bibliocifo"
        ) ?>
        <?= $template->css() ?>

		<!-- JS -->
		<script src="/js/TextReader.js"></script>
		<script src="/js/Modal.js"></script>
	</head>

	<body>

		<?= $template->header('Formulario de contacto') ?>
		<?= $template->menu() ?>
		<?= $template->messages() ?>

		<main>
    		<div class="flex-container gap2">
				<section class="flex1">
					<h2>Contacto</h2>
					<p>Uttiliza el formulario para contactar con el administrador de <?= APP_NAME ?>.</p>

					<form action="/Contacto/send" method="post">
						<label>Email</label>
						<input type="email" name="email" required value="<?= old('email')?>">
						<br>
						<label>Nombre</label>
						<input type="text" name="nombre" required value="<?= old('nombre')?>">
						<br>
						<label>Asunto</label>
						<input type="text" name="asunto" required value="<?= old('asunto')?>">
						<br>
						<label>Mensaje</label>
						<textarea name="mensaje" required><?= old('mensaje') ?></textarea>
						<br>
						<div class="centered mt2">
							<input type="submit" value="Enviar" name="enviar" class="button">
						</div>
					</form>
				</section>
				<section class="flex1">
					<h2>Ubicación y mapa</h2>
					<iframe id="mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2985.65043337072!2d2.0555340265492847!3d41.555165485570576!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a493650ae03931%3A0xee4ac6c8e8372532!2sCentre%20d&#39;Innovaci%C3%B3%20i%20Formaci%C3%B3%20Ocupacional%20(CIFO)%20de%20Sabadell!5e0!3m2!1sca!2ses!4v1774259333429!5m2!1sca!2ses"
						width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
					</iframe>
					<h3>Datos de contacto</h3>
					<p>
						CIFO Sabadell - Carretera nacional 150 km.15, 08227 Terrasa <br>
						Teléfono: 937362910<br>
						cifo_valles_soc@gencat.cat
					</p>
				</section>
			</div>

		</main>

		<?= $template->footer() ?>
		<?= $template->version() ?>

	</body>
</html>

