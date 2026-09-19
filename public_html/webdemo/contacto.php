<?php
$pagina_actual = 'contacto';
require_once __DIR__ . '/config/bootstrap.php';

$meta_titulo = 'Contacto — ' . $empresa_nombre;
$meta_descripcion = 'Escríbenos para más información sobre clases, horarios y sedes de ' . $empresa_nombre . '.';

$estado = isset($_GET['estado']) ? $_GET['estado'] : '';

require_once __DIR__ . '/partials/header.php';
?>

<main id="contenido">

	<section class="hero" style="padding-block: var(--esp-8) var(--esp-7);">
		<div class="container hero__inner">
			<span class="hero__kicker">Contacto</span>
			<h1>Hablemos</h1>
			<p>Cuéntanos qué necesitas y te responderemos a la brevedad. También puedes escribirnos directamente por WhatsApp.</p>
		</div>
	</section>

	<section class="seccion">
		<div class="container grid grid--2">
			<div data-animar>
				<?php if ($estado === 'ok'): ?>
					<div class="alerta alerta--exito">
						<i class="fa fa-check-circle" aria-hidden="true"></i>
						Tu mensaje fue enviado correctamente. Te contactaremos pronto.
					</div>
				<?php elseif ($estado === 'error'): ?>
					<div class="alerta alerta--error">
						<i class="fa fa-exclamation-circle" aria-hidden="true"></i>
						No pudimos enviar tu mensaje. Por favor, revisa los datos e intenta nuevamente.
					</div>
				<?php endif; ?>

				<form class="formulario" id="formContacto" action="controlador/contacto_enviar.php" method="post" novalidate>
					<div class="campo">
						<label for="nombre">Nombre completo</label>
						<input type="text" id="nombre" name="nombre" maxlength="150" required>
					</div>
					<div class="campo">
						<label for="email">Correo electrónico</label>
						<input type="email" id="email" name="email" maxlength="150" required>
					</div>
					<div class="campo">
						<label for="telefono">Teléfono (opcional)</label>
						<input type="tel" id="telefono" name="telefono" maxlength="20">
					</div>
					<div class="campo">
						<label for="mensaje">Mensaje</label>
						<textarea id="mensaje" name="mensaje" rows="5" maxlength="1000" required></textarea>
					</div>
					<button type="submit" class="btn btn--primario btn--bloque">Enviar mensaje</button>
				</form>
			</div>

			<div data-animar>
				<div class="card">
					<div class="card__cuerpo">
						<h3 class="card__titulo">Información de contacto</h3>
						<?php if (!empty($empresa_direccion)): ?>
							<p><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo h($empresa_direccion); ?></p>
						<?php endif; ?>
						<?php if (!empty($empresa_movil)): ?>
							<p><i class="fa fa-whatsapp" aria-hidden="true"></i> <?php echo h($empresa_movil); ?></p>
						<?php endif; ?>
						<?php if (!empty($empresa_email)): ?>
							<p><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo h($empresa_email); ?></p>
						<?php endif; ?>
						<?php if (!empty($empresa_movil)): ?>
							<a class="btn btn--whatsapp" href="<?php echo h(f_whatsapp($empresa_movil, 'Hola, quisiera información sobre ' . $empresa_nombre)); ?>" target="_blank" rel="noopener">
								<i class="fa fa-whatsapp" aria-hidden="true"></i> Escribir por WhatsApp
							</a>
						<?php endif; ?>
					</div>
				</div>

				<?php if (!empty($sedes)): ?>
					<div class="card" style="margin-top: var(--esp-5);">
						<div class="card__cuerpo">
							<h3 class="card__titulo">Nuestras sedes</h3>
							<ul class="site-footer__lista">
								<?php foreach ($sedes as $sede): ?>
									<li style="color:var(--color-texto-suave); margin-bottom: var(--esp-2);"><?php echo h($sede['V_NOMBRE']); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
