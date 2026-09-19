<?php
$pagina_actual = 'horarios';
require_once __DIR__ . '/config/bootstrap.php';

$meta_titulo = 'Horarios — ' . $empresa_nombre;
$meta_descripcion = 'Consulta los horarios de clases de Taekwondo vigentes en ' . $empresa_nombre . '.';

// Solo horarios con estado "vigente" (V_FLAG_ESTADO = '2'); '3' corresponde a
// horarios históricos/finalizados y '1' a borradores no publicados.
$horarios = db_query_all("
	SELECT h.*, s.V_NOMBRE AS SEDE_NOMBRE,
	       i.V_NOMBRES AS INST_NOMBRES, i.V_APE_PATERNO AS INST_APE_PATERNO, i.V_APE_MATERNO AS INST_APE_MATERNO,
	       t.V_DES_LARGA AS TURNO_NOMBRE
	FROM MOV_HORARIO h
	LEFT JOIN MAE_SEDE s ON s.N_COD_SEDE = h.N_COD_SEDE
	LEFT JOIN MAE_INSTRUCTOR i ON i.N_COD_INSTRUCTOR = h.N_COD_INSTRUCTOR
	LEFT JOIN MAE_CAT_TURNO t ON t.N_COD_CATURNO = h.N_COD_CATURNO
	WHERE h.V_FLAG_ESTADO = '2'
	ORDER BY s.V_NOMBRE ASC, h.D_HORA_INICIO ASC
");

require_once __DIR__ . '/partials/header.php';
?>

<main id="contenido">

	<section class="hero" style="padding-block: var(--esp-8) var(--esp-7);">
		<div class="container hero__inner">
			<span class="hero__kicker">Horarios</span>
			<h1>Horarios de clases vigentes</h1>
			<p>Revisa los días, horas y sedes disponibles. Escríbenos si tienes dudas sobre cuál horario se adapta mejor a ti.</p>
		</div>
	</section>

	<section class="seccion">
		<div class="container">
			<?php if (!empty($horarios)): ?>
				<div class="tabla-wrapper" data-animar>
					<table class="tabla-horarios">
						<thead>
							<tr>
								<th>Sede</th>
								<th>Días</th>
								<th>Hora</th>
								<th>Turno</th>
								<th>Instructor</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($horarios as $horario): ?>
								<tr>
									<td><?php echo h($horario['SEDE_NOMBRE']); ?></td>
									<td><?php echo h(f_dias_horario($horario)); ?></td>
									<td><?php echo h(f_hora_legible($horario['D_HORA_INICIO'])); ?></td>
									<td><?php echo h($horario['TURNO_NOMBRE']); ?></td>
									<td><?php echo h(!empty($horario['INST_NOMBRES']) ? f_nombre_completo($horario['INST_NOMBRES'], $horario['INST_APE_PATERNO'], $horario['INST_APE_MATERNO']) : '—'); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			<?php else: ?>
				<p>Pronto publicaremos los horarios vigentes. Escríbenos para más información.</p>
			<?php endif; ?>
		</div>
	</section>

	<section class="seccion seccion--alterna">
		<div class="container">
			<div class="cta-final" data-animar>
				<h2>¿Tienes dudas sobre los horarios?</h2>
				<p>Contáctanos y te ayudamos a elegir el horario y la sede ideal para ti.</p>
				<div class="hero__acciones">
					<a href="contacto.php" class="btn btn--oscuro">Contáctanos</a>
				</div>
			</div>
		</div>
	</section>

</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
