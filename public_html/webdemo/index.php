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

// Últimas graduaciones/cambios de cinturón realizados (histórico real, no fechas inventadas).
$graduaciones_recientes = db_query_all("
	SELECT p.V_DESCRIPCION, p.V_LUGAR, p.D_FEC_PROG, s.V_NOMBRE AS SEDE_NOMBRE
	FROM MOV_PROMOCION p
	LEFT JOIN MAE_SEDE s ON s.N_COD_SEDE = p.N_COD_SEDE
	WHERE p.D_FEC_PROG IS NOT NULL
	ORDER BY p.D_FEC_PROG DESC
	LIMIT 4
");

// Eventos/campeonatos en los que ha participado la academia (histórico real).
$eventos_recientes = db_query_all("
	SELECT V_DESCRIPCION, V_LUGAR, D_FECHA
	FROM MOV_EVENTO
	WHERE D_FECHA IS NOT NULL
	ORDER BY D_FECHA DESC
	LIMIT 3
");

require_once __DIR__ . '/partials/header.php';
?>

<main id="contenido">

	<section class="hero hero--portada" style="background-image:url('recursos/images/t_fondo.jpg');">
		<div class="container hero__grid">
			<div class="hero__inner">
				<span class="hero__kicker"><i class="fa fa-shield" aria-hidden="true"></i> Academia de Taekwondo WT</span>
				<h1><?php echo h($empresa_nombre); ?></h1>
				<p><?php echo h(!empty($empresa_lema) ? $empresa_lema : 'Formamos disciplina, respeto y fortaleza a través del taekwondo, con clases para toda la familia en nuestras sedes de Chachapoyas.'); ?></p>
				<div class="hero__acciones">
					<a href="contacto.php" class="btn btn--primario btn--grande">
						<i class="fa fa-paper-plane" aria-hidden="true"></i> Solicitar información
					</a>
					<a href="horarios.php" class="btn btn--secundario btn--grande">
						<i class="fa fa-calendar" aria-hidden="true"></i> Ver horarios
					</a>
				</div>
				<div class="hero__confianza">
					<span><i class="fa fa-check-circle" aria-hidden="true"></i> Instructores certificados</span>
					<span><i class="fa fa-check-circle" aria-hidden="true"></i> Múltiples sedes</span>
					<span><i class="fa fa-check-circle" aria-hidden="true"></i> Todas las edades</span>
				</div>
			</div>

			<div class="hero__tarjeta" data-animar>
				<div class="hero__tarjeta-cabecera">
					<span class="hero__tarjeta-belt" aria-hidden="true"></span>
					<strong>Resumen de la academia</strong>
				</div>
				<div class="hero__tarjeta-stats">
					<div>
						<span class="hero__tarjeta-num"><?php echo (int) $total_sedes; ?></span>
						<span><?php echo $total_sedes == 1 ? 'Sede' : 'Sedes'; ?></span>
					</div>
					<div>
						<span class="hero__tarjeta-num"><?php echo (int) $total_instructores; ?></span>
						<span><?php echo $total_instructores == 1 ? 'Instructor' : 'Instructores'; ?></span>
					</div>
					<div>
						<span class="hero__tarjeta-num"><?php echo count($cinturones); ?></span>
						<span>Grados</span>
					</div>
				</div>
				<a href="contacto.php" class="hero__tarjeta-cta">
					Reserva tu clase de prueba <i class="fa fa-angle-right" aria-hidden="true"></i>
				</a>
			</div>
		</div>
		<span class="hero__scroll" aria-hidden="true"></span>
	</section>

	<section class="stats">
		<div class="container stats__grid">
			<div data-animar>
				<span class="stats__icono"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
				<span class="stats__numero"><?php echo (int) $total_sedes; ?></span>
				<span class="stats__etiqueta"><?php echo $total_sedes == 1 ? 'Sede' : 'Sedes'; ?> en Chachapoyas</span>
			</div>
			<div data-animar>
				<span class="stats__icono"><i class="fa fa-user" aria-hidden="true"></i></span>
				<span class="stats__numero"><?php echo (int) $total_instructores; ?></span>
				<span class="stats__etiqueta"><?php echo $total_instructores == 1 ? 'Instructor certificado' : 'Instructores certificados'; ?></span>
			</div>
			<div data-animar>
				<span class="stats__icono"><i class="fa fa-certificate" aria-hidden="true"></i></span>
				<span class="stats__numero"><?php echo count($cinturones); ?></span>
				<span class="stats__etiqueta">Niveles de cinturón</span>
			</div>
			<div data-animar>
				<span class="stats__icono"><i class="fa fa-shield" aria-hidden="true"></i></span>
				<span class="stats__numero">100%</span>
				<span class="stats__etiqueta">Enfoque en disciplina y valores</span>
			</div>
		</div>
	</section>

	<section class="seccion">
		<div class="container grid grid--tkd">
			<div data-animar>
				<span class="seccion__kicker">¿Qué es el Taekwondo?</span>
				<h2 class="seccion__titulo">Mucho más que patadas</h2>
				<p>El Taekwondo (태권도) es un arte marcial coreano reconocido como deporte olímpico, que combina técnicas de golpeo con manos y pies, alta exigencia física y una filosofía basada en el respeto, la disciplina y la superación personal. Es practicado por millones de personas en el mundo, en la Federación Mundial de Taekwondo (World Taekwondo).</p>
				<p>En nuestras clases, cada estudiante avanza a su propio ritmo dentro de un sistema de grados (cinturones) que reconoce tanto el nivel técnico como el compromiso y los valores demostrados dentro y fuera del dojang.</p>
				<a href="nosotros.php" class="btn btn--primario">Conocer nuestra metodología</a>
			</div>
			<div class="video-embed" data-animar>
				<div class="video-embed__frame">
					<iframe src="https://www.youtube.com/embed/Y6JkrMVw4Lo" title="Presentación oficial de World Taekwondo" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
				<p class="video-embed__credito">Video oficial de <a href="https://www.youtube.com/@worldtaekwondo" target="_blank" rel="noopener">World Taekwondo</a>, la federación internacional del deporte.</p>
			</div>
		</div>
	</section>

	<section class="seccion seccion--alterna">
		<div class="container">
			<div class="seccion__cabecera" data-animar>
				<span class="seccion__kicker">Beneficios</span>
				<h2 class="seccion__titulo">Por qué practicar Taekwondo</h2>
				<p>Un entrenamiento completo que trabaja el cuerpo y la mente, con beneficios que se notan dentro y fuera del dojang.</p>
			</div>
			<div class="grid grid--3">
				<div class="card card--feature" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Salud física</h3>
						<p class="card__meta">Mejora la fuerza, flexibilidad, coordinación y resistencia cardiovascular en cada sesión.</p>
					</div>
				</div>
				<div class="card card--feature" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono"><i class="fa fa-shield" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Defensa personal</h3>
						<p class="card__meta">Técnicas prácticas de defensa que generan seguridad y confianza en cualquier situación.</p>
					</div>
				</div>
				<div class="card card--feature" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono"><i class="fa fa-smile-o" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Confianza y autoestima</h3>
						<p class="card__meta">Cada nuevo cinturón refuerza la autodisciplina y la seguridad en uno mismo.</p>
					</div>
				</div>
				<div class="card card--feature" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono"><i class="fa fa-balance-scale" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Disciplina y enfoque</h3>
						<p class="card__meta">Rutinas estructuradas que mejoran la concentración dentro y fuera de clase.</p>
					</div>
				</div>
				<div class="card card--feature" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono"><i class="fa fa-users" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Valores y comunidad</h3>
						<p class="card__meta">Respeto, cortesía e integridad, practicados junto a compañeros de todas las edades.</p>
					</div>
				</div>
				<div class="card card--feature" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono"><i class="fa fa-bolt" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Manejo del estrés</h3>
						<p class="card__meta">Una vía saludable para liberar energía y tensión, dentro de una rutina constante.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="seccion seccion--publico">
		<div class="container">
			<div class="seccion__cabecera" data-animar>
				<span class="seccion__kicker">¿Para quién son las clases?</span>
				<h2 class="seccion__titulo">Taekwondo para toda la familia</h2>
				<p>Formamos a cada estudiante según su etapa: desde los primeros pasos en la infancia hasta el entrenamiento competitivo en la adultez.</p>
			</div>
			<div class="grid grid--4">
				<div class="card card--feature card--publico" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono feature-card__icono--publico"><i class="fa fa-child" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Niños</h3>
						<p class="card__meta">Coordinación, disciplina y respeto desde temprana edad, en un ambiente seguro y divertido.</p>
					</div>
				</div>
				<div class="card card--feature card--publico" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono feature-card__icono--publico"><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Adolescentes</h3>
						<p class="card__meta">Carácter, confianza y técnica en una etapa clave de su desarrollo personal.</p>
					</div>
				</div>
				<div class="card card--feature card--publico" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono feature-card__icono--publico"><i class="fa fa-female" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Damas</h3>
						<p class="card__meta">Defensa personal, acondicionamiento físico y superación, a cualquier edad.</p>
					</div>
				</div>
				<div class="card card--feature card--publico" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono feature-card__icono--publico"><i class="fa fa-male" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Varones</h3>
						<p class="card__meta">Entrenamiento técnico y físico para jóvenes y adultos que buscan un reto real.</p>
					</div>
				</div>
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

	<section class="seccion" id="plataforma">
		<div class="container">
			<div class="seccion__cabecera" data-animar>
				<span class="seccion__kicker">Plataforma para familias</span>
				<h2 class="seccion__titulo">Todo el seguimiento de tu hijo, en un solo lugar</h2>
				<p>Además de las clases presenciales, padres y estudiantes acceden a un sistema en línea para seguir de cerca su progreso, sin depender de llamadas o mensajes sueltos.</p>
			</div>
			<div class="grid grid--3">
				<div class="card card--feature" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono"><i class="fa fa-tags" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Promociones</h3>
						<p class="card__meta">Campañas y descuentos vigentes visibles para los estudiantes, sin tener que preguntar en sede.</p>
					</div>
				</div>
				<div class="card card--feature" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono"><i class="fa fa-certificate" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Graduaciones</h3>
						<p class="card__meta">Historial de exámenes y ascensos de cinturón de cada estudiante, con fecha y grado obtenido.</p>
					</div>
				</div>
				<div class="card card--feature" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono"><i class="fa fa-check-square-o" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Control de asistencias</h3>
						<p class="card__meta">Registro de asistencia por clase, para que el padre sepa si su hijo asistió sin tener que preguntar.</p>
					</div>
				</div>
				<div class="card card--feature" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono"><i class="fa fa-star-o" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Notas y evaluaciones</h3>
						<p class="card__meta">Desempeño técnico registrado por el instructor en cada sesión o evaluación de grado.</p>
					</div>
				</div>
				<div class="card card--feature" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono"><i class="fa fa-heart-o" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Seguimiento para el padre</h3>
						<p class="card__meta">Un panel propio para que cada padre o estudiante revise su progreso, asistencia y pagos desde su cuenta.</p>
					</div>
				</div>
				<div class="card card--feature" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Horarios actualizados</h3>
						<p class="card__meta">Días, horas, sede e instructor de cada clase, siempre al día y consultables desde el celular.</p>
					</div>
				</div>
				<div class="card card--feature" data-animar>
					<div class="card__cuerpo card__cuerpo--feature">
						<span class="feature-card__icono"><i class="fa fa-credit-card" aria-hidden="true"></i></span>
						<h3 class="card__titulo">Pagos flexibles</h3>
						<p class="card__meta">Distintas modalidades de pago (mensual, por paquete de clases) y registro de pagos por estudiante.</p>
					</div>
				</div>
			</div>

			<div class="medios-pago" data-animar>
				<span class="medios-pago__titulo">Medios de pago aceptados</span>
				<div class="medios-pago__lista">
					<span class="medio-pago"><i class="fa fa-credit-card" aria-hidden="true"></i> Tarjeta de crédito/débito</span>
					<span class="medio-pago medio-pago--yape"><i class="fa fa-mobile" aria-hidden="true"></i> Yape</span>
					<span class="medio-pago medio-pago--plin"><i class="fa fa-mobile" aria-hidden="true"></i> Plin</span>
					<span class="medio-pago"><i class="fa fa-university" aria-hidden="true"></i> Transferencia bancaria</span>
					<span class="medio-pago"><i class="fa fa-money" aria-hidden="true"></i> Efectivo en sede</span>
				</div>
			</div>
		</div>
	</section>

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

	<?php if (!empty($graduaciones_recientes) || !empty($eventos_recientes)): ?>
	<section class="seccion">
		<div class="container">
			<div class="seccion__cabecera" data-animar>
				<span class="seccion__kicker">Vida en la academia</span>
				<h2 class="seccion__titulo">Graduaciones y eventos</h2>
				<p>Un vistazo a nuestras últimas ceremonias de cambio de cinturón y participación en campeonatos.</p>
			</div>

			<?php if (!empty($graduaciones_recientes)): ?>
				<h3 class="cronologia__subtitulo">Últimas graduaciones de cinturón</h3>
				<div class="grid grid--3">
					<?php foreach ($graduaciones_recientes as $grad): ?>
						<div class="card card--feature" data-animar>
							<div class="card__cuerpo card__cuerpo--feature">
								<span class="feature-card__icono"><i class="fa fa-certificate" aria-hidden="true"></i></span>
								<h3 class="card__titulo"><?php echo h($grad['V_DESCRIPCION']); ?></h3>
								<p class="card__meta">
									<i class="fa fa-calendar" aria-hidden="true"></i>
									<?php echo h(date('d/m/Y', strtotime($grad['D_FEC_PROG']))); ?>
									<?php if (!empty($grad['SEDE_NOMBRE'])): ?> · <?php echo h($grad['SEDE_NOMBRE']); ?><?php endif; ?>
								</p>
								<?php if (!empty($grad['V_LUGAR'])): ?>
									<p class="card__meta"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo h($grad['V_LUGAR']); ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if (!empty($eventos_recientes)): ?>
				<h3 class="cronologia__subtitulo" style="margin-top: var(--esp-7);">Participación en eventos y campeonatos</h3>
				<div class="grid grid--3">
					<?php foreach ($eventos_recientes as $evento): ?>
						<div class="card card--feature" data-animar>
							<div class="card__cuerpo card__cuerpo--feature">
								<span class="feature-card__icono"><i class="fa fa-trophy" aria-hidden="true"></i></span>
								<h3 class="card__titulo"><?php echo h($evento['V_DESCRIPCION']); ?></h3>
								<p class="card__meta">
									<i class="fa fa-calendar" aria-hidden="true"></i>
									<?php echo h(date('d/m/Y', strtotime($evento['D_FECHA']))); ?>
								</p>
								<?php if (!empty($evento['V_LUGAR'])): ?>
									<p class="card__meta"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo h($evento['V_LUGAR']); ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<p class="faq-panel__intro" style="text-align:center; margin-top: var(--esp-6);">¿Quieres que te avisemos de la próxima fecha de graduación? <a href="contacto.php">Escríbenos</a>.</p>
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
