<?php
$pagina_actual = 'sedes';
require_once __DIR__ . '/config/bootstrap.php';

$meta_titulo = 'Sedes — ' . $empresa_nombre;
$meta_descripcion = 'Encuentra la sede de ' . $empresa_nombre . ' más cercana a ti en Chachapoyas.';

// Cantidad de horarios vigentes por sede, para el comparador.
$conteo_horarios_sede = db_query_all("
	SELECT s.N_COD_SEDE, COUNT(h.N_COD_HORARIO) AS TOTAL_HORARIOS
	FROM MAE_SEDE s
	LEFT JOIN MOV_HORARIO h ON h.N_COD_SEDE = s.N_COD_SEDE AND h.V_FLAG_ESTADO = '2'
	WHERE s.V_FLAG_ESTADO = '1'
	GROUP BY s.N_COD_SEDE
");
$horarios_por_sede = array();
foreach ($conteo_horarios_sede as $fila) {
	$horarios_por_sede[$fila['N_COD_SEDE']] = (int) $fila['TOTAL_HORARIOS'];
}

require_once __DIR__ . '/partials/header.php';
?>

<main id="contenido">

	<section class="hero" style="padding-block: var(--esp-8) var(--esp-7);">
		<div class="container hero__inner">
			<span class="hero__kicker">Nuestras sedes</span>
			<h1>Encuentra la sede más cercana</h1>
			<p>Contamos con varias sedes en Chachapoyas para que puedas entrenar cerca de tu casa o centro de estudios.</p>
		</div>
	</section>

	<section class="seccion">
		<div class="container">
			<?php if (!empty($sedes)): ?>
				<div class="grid grid--3">
					<?php foreach ($sedes as $sede): ?>
						<div class="card card--sede" data-animar>
							<div class="card__imagen">
								<img src="<?php echo h(f_foto_o_placeholder($sede['V_FOTO'], SITE_UPLOAD_SEDE_DIR, 'recursos/images/t_fondo.jpg')); ?>" alt="<?php echo h($sede['V_NOMBRE']); ?>" loading="lazy">
							</div>
							<div class="card__cuerpo">
								<h3 class="card__titulo"><?php echo h($sede['V_NOMBRE']); ?></h3>
								<?php if (!empty($sede['V_DIRECCION'])): ?>
									<p class="card__meta"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo h($sede['V_DIRECCION']); ?></p>
								<?php endif; ?>
								<?php if (!empty($sede['V_REFERENCIA'])): ?>
									<p class="card__meta"><?php echo h($sede['V_REFERENCIA']); ?></p>
								<?php endif; ?>
								<?php if (!empty($sede['V_MOVIL'])): ?>
									<a href="<?php echo h(f_whatsapp($sede['V_MOVIL'], 'Hola, quisiera información sobre la sede ' . $sede['V_NOMBRE'])); ?>" class="btn btn--whatsapp" target="_blank" rel="noopener">
										<i class="fa fa-whatsapp" aria-hidden="true"></i> Escribir por WhatsApp
									</a>
								<?php elseif (!empty($sede['V_FONO'])): ?>
									<p class="card__meta"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo h($sede['V_FONO']); ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else: ?>
				<p>Pronto publicaremos la información de nuestras sedes.</p>
			<?php endif; ?>
		</div>
	</section>

	<?php if (!empty($sedes) && count($sedes) > 1): ?>
	<section class="seccion seccion--alterna">
		<div class="container">
			<div class="seccion__cabecera" data-animar>
				<span class="seccion__kicker">Comparador</span>
				<h2 class="seccion__titulo">Compara nuestras sedes</h2>
				<p>Una vista rápida para elegir la sede que mejor se ajusta a ti.</p>
			</div>
			<div class="tabla-wrapper" data-animar>
				<table class="tabla-horarios">
					<thead>
						<tr>
							<th>Sede</th>
							<th>Dirección</th>
							<th>Horarios vigentes</th>
							<th>Contacto</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($sedes as $sede): ?>
							<tr>
								<td><strong><?php echo h($sede['V_NOMBRE']); ?></strong></td>
								<td><?php echo h(!empty($sede['V_DIRECCION']) ? $sede['V_DIRECCION'] : '—'); ?></td>
								<td><?php echo (int) (isset($horarios_por_sede[$sede['N_COD_SEDE']]) ? $horarios_por_sede[$sede['N_COD_SEDE']] : 0); ?></td>
								<td>
									<?php if (!empty($sede['V_MOVIL'])): ?>
										<a href="<?php echo h(f_whatsapp($sede['V_MOVIL'], 'Hola, quisiera información sobre la sede ' . $sede['V_NOMBRE'])); ?>" target="_blank" rel="noopener">
											<i class="fa fa-whatsapp" aria-hidden="true"></i> WhatsApp
										</a>
									<?php elseif (!empty($sede['V_FONO'])): ?>
										<?php echo h($sede['V_FONO']); ?>
									<?php else: ?>
										—
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<?php endif; ?>

</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
