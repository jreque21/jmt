<?php
$pagina_actual = 'instructores';
require_once __DIR__ . '/config/bootstrap.php';

$meta_titulo = 'Instructores — ' . $empresa_nombre;
$meta_descripcion = 'Conoce a los instructores certificados de ' . $empresa_nombre . ', academia de Taekwondo WT en Chachapoyas.';

$instructores = db_query_all("
	SELECT i.*, c.V_DES_LARGA AS CINTURON_NOMBRE, c.V_COD_COLOR AS CINTURON_COLOR
	FROM MAE_INSTRUCTOR i
	LEFT JOIN MAE_CINTURON c ON c.N_COD_CINTURON = i.N_COD_CINTURON
	WHERE i.V_FLAG_ESTADO = '1'
	ORDER BY i.V_APE_PATERNO ASC
");

require_once __DIR__ . '/partials/header.php';
?>

<main id="contenido">

	<section class="hero" style="padding-block: var(--esp-8) var(--esp-7);">
		<div class="container hero__inner">
			<span class="hero__kicker">Nuestro equipo</span>
			<h1>Instructores certificados</h1>
			<p>Un equipo comprometido con la enseñanza técnica del Taekwondo WT y la formación en valores de cada estudiante.</p>
		</div>
	</section>

	<section class="seccion">
		<div class="container">
			<?php if (!empty($instructores)): ?>
				<div class="grid grid--3">
					<?php foreach ($instructores as $instructor): ?>
						<div class="card" data-animar>
							<div class="card__imagen">
								<img src="<?php echo h(f_foto_o_placeholder($instructor['V_FOTO'], SITE_UPLOAD_INSTRUCTOR_DIR, 'recursos/images/b_instructor.png')); ?>" alt="<?php echo h(f_nombre_completo($instructor['V_NOMBRES'], $instructor['V_APE_PATERNO'], $instructor['V_APE_MATERNO'])); ?>" loading="lazy">
							</div>
							<div class="card__cuerpo">
								<h3 class="card__titulo"><?php echo h(f_nombre_completo($instructor['V_NOMBRES'], $instructor['V_APE_PATERNO'], $instructor['V_APE_MATERNO'])); ?></h3>
								<p class="card__meta">Instructor de Taekwondo</p>
								<?php if (!empty($instructor['CINTURON_NOMBRE'])): ?>
									<span class="cinturon-chip" style="margin-top: var(--esp-2);">
										<span class="cinturon-chip__color" style="background:<?php echo h($instructor['CINTURON_COLOR']); ?>"></span>
										<?php echo h($instructor['CINTURON_NOMBRE']); ?>
									</span>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else: ?>
				<p>Pronto publicaremos la información de nuestros instructores.</p>
			<?php endif; ?>
		</div>
	</section>

</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
