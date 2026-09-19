<?php
$pagina_actual = 'nosotros';
require_once __DIR__ . '/config/bootstrap.php';

$meta_titulo = 'Nosotros — ' . $empresa_nombre;
$meta_descripcion = 'Conoce la misión, visión y el sistema de cinturones de ' . $empresa_nombre . ', academia de Taekwondo WT en Chachapoyas.';

$cinturones = db_query_all("SELECT * FROM MAE_CINTURON WHERE V_FLAG_ESTADO = '1' ORDER BY N_ORDEN ASC");

require_once __DIR__ . '/partials/header.php';
?>

<main id="contenido">

	<section class="hero" style="padding-block: var(--esp-8) var(--esp-7);">
		<div class="container hero__inner">
			<span class="hero__kicker">Nosotros</span>
			<h1>Formando taekwondistas con disciplina y respeto</h1>
			<p><?php echo h(!empty($empresa['V_BIENVENIDA']) ? $empresa['V_BIENVENIDA'] : 'Somos una academia dedicada a la enseñanza del Taekwondo WT en Chachapoyas, con un enfoque en el desarrollo físico, mental y en valores de cada estudiante.'); ?></p>
		</div>
	</section>

	<section class="seccion">
		<div class="container grid grid--2">
			<div class="card" data-animar>
				<div class="card__cuerpo">
					<h3 class="card__titulo"><i class="fa fa-bullseye" aria-hidden="true" style="color:var(--color-primario);"></i> Misión</h3>
					<p><?php echo h(!empty($empresa['V_MISION']) ? $empresa['V_MISION'] : 'Brindar una formación de calidad en Taekwondo WT, promoviendo la disciplina, el respeto y la superación personal en niños, jóvenes y adultos de Chachapoyas.'); ?></p>
				</div>
			</div>
			<div class="card" data-animar>
				<div class="card__cuerpo">
					<h3 class="card__titulo"><i class="fa fa-eye" aria-hidden="true" style="color:var(--color-primario);"></i> Visión</h3>
					<p><?php echo h(!empty($empresa['V_VISION']) ? $empresa['V_VISION'] : 'Ser una de las academias de Taekwondo de referencia en la región, reconocida por la calidad de su enseñanza y la formación integral de sus estudiantes.'); ?></p>
				</div>
			</div>
		</div>
	</section>

	<?php if (!empty($cinturones)): ?>
	<section class="seccion seccion--alterna">
		<div class="container">
			<div class="seccion__cabecera" data-animar>
				<span class="seccion__kicker">Sistema de grados</span>
				<h2 class="seccion__titulo">Sistema de cinturones</h2>
				<p>El progreso de cada estudiante se reconoce a través de un sistema de cinturones, desde los primeros grados hasta el cinturón negro.</p>
			</div>
			<div class="grid grid--3">
				<?php foreach ($cinturones as $cinturon): ?>
					<div class="card" data-animar>
						<div class="card__cuerpo" style="display:flex; align-items:center; gap: var(--esp-3);">
							<span class="cinturon-chip__color" style="width:32px; height:32px; flex-shrink:0; background:<?php echo h($cinturon['V_COD_COLOR']); ?>"></span>
							<div>
								<h3 class="card__titulo" style="margin-bottom:0;"><?php echo h($cinturon['V_DES_LARGA']); ?></h3>
								<?php if (!empty($cinturon['V_DES_CORTA'])): ?>
									<p class="card__meta"><?php echo h($cinturon['V_DES_CORTA']); ?></p>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if (!empty($cinturones) && count($cinturones) > 1): ?>
	<section class="seccion">
		<div class="container">
			<div class="calculadora-cinturon" data-animar>
				<div class="calculadora-cinturon__texto">
					<span class="seccion__kicker">Herramienta</span>
					<h2 class="seccion__titulo">¿Cuánto te falta para el cinturón negro?</h2>
					<p>Elige tu cinturón actual y te mostramos cuántos grados te faltan dentro de nuestro sistema de <?php echo count($cinturones); ?> niveles.</p>
				</div>
				<div class="calculadora-cinturon__caja">
					<label for="selectCinturon">Mi cinturón actual es:</label>
					<select id="selectCinturon" data-total-grados="<?php echo (int) count($cinturones); ?>">
						<?php foreach ($cinturones as $indice => $cinturon): ?>
							<option value="<?php echo (int) ($indice + 1); ?>"><?php echo h($cinturon['V_DES_LARGA']); ?></option>
						<?php endforeach; ?>
					</select>

					<div class="calculadora-cinturon__resultado" id="resultadoCinturon">
						<div class="calculadora-cinturon__barra">
							<div class="calculadora-cinturon__progreso" id="barraCinturon"></div>
						</div>
						<p id="textoResultadoCinturon"></p>
						<a href="contacto.php" class="btn btn--primario">Consultar mi plan de avance</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="seccion">
		<div class="container">
			<div class="seccion__cabecera" data-animar>
				<span class="seccion__kicker">Nuestros valores</span>
				<h2 class="seccion__titulo">Lo que nos define</h2>
			</div>
			<div class="grid grid--3">
				<div class="card" data-animar>
					<div class="card__cuerpo">
						<h3 class="card__titulo"><i class="fa fa-shield" aria-hidden="true" style="color:var(--color-primario);"></i> Disciplina</h3>
						<p>Cada clase refuerza el compromiso, la puntualidad y la constancia dentro y fuera del dojang.</p>
					</div>
				</div>
				<div class="card" data-animar>
					<div class="card__cuerpo">
						<h3 class="card__titulo"><i class="fa fa-handshake-o" aria-hidden="true" style="color:var(--color-primario);"></i> Respeto</h3>
						<p>Formamos estudiantes que respetan a sus compañeros, instructores y a sí mismos.</p>
					</div>
				</div>
				<div class="card" data-animar>
					<div class="card__cuerpo">
						<h3 class="card__titulo"><i class="fa fa-line-chart" aria-hidden="true" style="color:var(--color-primario);"></i> Superación</h3>
						<p>Acompañamos a cada estudiante en su progreso técnico, a su propio ritmo.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
