<?php
$pagina_actual = 'inicio';
require_once __DIR__ . '/config/bootstrap.php';

$meta_titulo = $empresa_nombre . ' — Academia de Taekwondo en Chachapoyas';
$meta_descripcion = 'Escuela de Taekwondo WT con varias sedes en Chachapoyas. Clases para niños, jóvenes y adultos, con instructores certificados.';

$total_sedes = count($sedes);
$instructores_home = db_query_all("SELECT * FROM MAE_INSTRUCTOR WHERE V_FLAG_ESTADO = '1' ORDER BY V_APE_PATERNO ASC LIMIT 3");
$total_instructores = db_query_all("SELECT COUNT(*) AS N FROM MAE_INSTRUCTOR WHERE V_FLAG_ESTADO = '1'");
$total_instructores = !empty($total_instructores) ? (int) $total_instructores[0]['N'] : 0;
$cinturones = db_query_all("SELECT * FROM MAE_CINTURON WHERE V_FLAG_ESTADO = '1' ORDER BY N_ORDEN ASC");

require_once __DIR__ . '/partials/header.php';
?>

<main id="contenido">

	<section class="hero" style="background-image:url('recursos/images/t_fondo.jpg');">
		<div class="container hero__inner">
			<span class="hero__kicker">Academia de Taekwondo WT</span>
			<h1><?php echo h($empresa_nombre); ?></h1>
			<p><?php echo h(!empty($empresa_lema) ? $empresa_lema : 'Formamos disciplina, respeto y fortaleza a través del taekwondo, con clases para toda la familia en nuestras sedes de Chachapoyas.'); ?></p>
			<div class="hero__acciones">
				<a href="contacto.php" class="btn btn--primario">Solicitar información</a>
				<a href="horarios.php" class="btn btn--secundario">Ver horarios</a>
			</div>
		</div>
	</section>

	<section class="stats">
		<div class="container stats__grid">
			<div>
				<span class="stats__numero"><?php echo (int) $total_sedes; ?></span>
				<span class="stats__etiqueta"><?php echo $total_sedes == 1 ? 'Sede' : 'Sedes'; ?> en Chachapoyas</span>
			</div>
			<div>
				<span class="stats__numero"><?php echo (int) $total_instructores; ?></span>
				<span class="stats__etiqueta"><?php echo $total_instructores == 1 ? 'Instructor certificado' : 'Instructores certificados'; ?></span>
			</div>
			<div>
				<span class="stats__numero"><?php echo count($cinturones); ?></span>
				<span class="stats__etiqueta">Niveles de cinturón</span>
			</div>
			<div>
				<span class="stats__numero">100%</span>
				<span class="stats__etiqueta">Enfoque en disciplina y valores</span>
			</div>
		</div>
	</section>

	<section class="seccion">
		<div class="container">
			<div class="seccion__cabecera" data-animar>
				<span class="seccion__kicker">Nuestras sedes</span>
				<h2 class="seccion__titulo">Entrena cerca de ti</h2>
				<p>Contamos con sedes distribuidas en Chachapoyas para que encuentres la más cercana a tu casa o centro de estudios.</p>
			</div>

			<div class="grid grid--3">
				<?php foreach (array_slice($sedes, 0, 3) as $sede): ?>
					<div class="card card--sede" data-animar>
						<div class="card__imagen">
							<img src="<?php echo h(f_foto_o_placeholder($sede['V_FOTO'], SITE_UPLOAD_SEDE_DIR, 'recursos/images/t_fondo.jpg')); ?>" alt="<?php echo h($sede['V_NOMBRE']); ?>" loading="lazy">
						</div>
						<div class="card__cuerpo">
							<h3 class="card__titulo"><?php echo h($sede['V_NOMBRE']); ?></h3>
							<p class="card__meta"><?php echo h($sede['V_DIRECCION']); ?></p>
							<a href="sedes.php" class="btn btn--primario">Ver sede</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php if (!empty($cinturones)): ?>
	<section class="seccion seccion--alterna">
		<div class="container">
			<div class="seccion__cabecera" data-animar>
				<span class="seccion__kicker">Sistema de grados</span>
				<h2 class="seccion__titulo">Sistema de cinturones</h2>
				<p>Un camino de progreso claro, del cinturón blanco al negro, que reconoce la constancia y el nivel técnico de cada estudiante.</p>
			</div>
			<div class="cinturones" data-animar>
				<?php foreach ($cinturones as $cinturon): ?>
					<span class="cinturon-chip">
						<span class="cinturon-chip__color" style="background:<?php echo h($cinturon['V_COD_COLOR']); ?>"></span>
						<?php echo h($cinturon['V_DES_LARGA']); ?>
					</span>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if (!empty($instructores_home)): ?>
	<section class="seccion">
		<div class="container">
			<div class="seccion__cabecera" data-animar>
				<span class="seccion__kicker">Nuestro equipo</span>
				<h2 class="seccion__titulo">Instructores certificados</h2>
				<p>Profesionales formados en Taekwondo WT, comprometidos con la enseñanza técnica y los valores del deporte.</p>
			</div>
			<div class="grid grid--3">
				<?php foreach ($instructores_home as $instructor): ?>
					<div class="card" data-animar>
						<div class="card__imagen">
							<img src="<?php echo h(f_foto_o_placeholder($instructor['V_FOTO'], SITE_UPLOAD_INSTRUCTOR_DIR, 'recursos/images/b_instructor.png')); ?>" alt="<?php echo h(f_nombre_completo($instructor['V_NOMBRES'], $instructor['V_APE_PATERNO'], $instructor['V_APE_MATERNO'])); ?>" loading="lazy">
						</div>
						<div class="card__cuerpo">
							<h3 class="card__titulo"><?php echo h(f_nombre_completo($instructor['V_NOMBRES'], $instructor['V_APE_PATERNO'], $instructor['V_APE_MATERNO'])); ?></h3>
							<p class="card__meta">Instructor de Taekwondo</p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="seccion seccion--alterna">
		<div class="container">
			<div class="cta-final" data-animar>
				<h2>¿Listo para empezar a entrenar?</h2>
				<p>Escríbenos y te ayudamos a elegir la sede y el horario que mejor se adapten a ti o a tu familia.</p>
				<div class="hero__acciones">
					<a href="contacto.php" class="btn btn--oscuro">Contáctanos</a>
					<?php if (!empty($empresa_movil)): ?>
						<a href="<?php echo h(f_whatsapp($empresa_movil, 'Hola, quisiera información sobre las clases de taekwondo')); ?>" class="btn btn--secundario" target="_blank" rel="noopener" style="color:var(--color-secundario);border-color:var(--color-secundario);">
							<i class="fa fa-whatsapp" aria-hidden="true"></i> WhatsApp
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
