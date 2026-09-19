<footer class="site-footer">
	<div class="container site-footer__inner">
		<div class="site-footer__col">
			<a href="index.php" class="brand brand--footer">
				<img src="<?php echo h($empresa_logo); ?>" alt="<?php echo h($empresa_nombre); ?>" class="brand__logo">
				<span class="brand__text">
					<strong><?php echo h($empresa_nombre); ?></strong>
					<small><?php echo h($empresa_lema); ?></small>
				</span>
			</a>
			<?php if (!empty($empresa_direccion)): ?>
				<p class="site-footer__linea"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo h($empresa_direccion); ?></p>
			<?php endif; ?>
			<?php if (!empty($empresa_movil)): ?>
				<p class="site-footer__linea">
					<i class="fa fa-whatsapp" aria-hidden="true"></i>
					<a href="<?php echo h(f_whatsapp($empresa_movil, 'Hola, quisiera más información sobre ' . $empresa_nombre)); ?>" target="_blank" rel="noopener">
						<?php echo h($empresa_movil); ?>
					</a>
				</p>
			<?php endif; ?>
			<?php if (!empty($empresa_email)): ?>
				<p class="site-footer__linea"><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo h($empresa_email); ?></p>
			<?php endif; ?>
		</div>

		<div class="site-footer__col">
			<h4 class="site-footer__titulo">Sedes</h4>
			<ul class="site-footer__lista">
				<?php if (!empty($sedes)): ?>
					<?php foreach ($sedes as $sede): ?>
						<li><a href="sedes.php"><?php echo h($sede['V_NOMBRE']); ?></a></li>
					<?php endforeach; ?>
				<?php else: ?>
					<li><a href="sedes.php">Ver todas las sedes</a></li>
				<?php endif; ?>
			</ul>
		</div>

		<div class="site-footer__col">
			<h4 class="site-footer__titulo">Enlaces</h4>
			<ul class="site-footer__lista">
				<li><a href="nosotros.php">Nosotros</a></li>
				<li><a href="instructores.php">Instructores</a></li>
				<li><a href="horarios.php">Horarios</a></li>
				<li><a href="contacto.php">Contacto</a></li>
				<li><a href="../index.php">Acceso Estudiantes</a></li>
			</ul>
		</div>

		<div class="site-footer__col">
			<h4 class="site-footer__titulo">Síguenos</h4>
			<div class="site-footer__social">
				<?php if (!empty($empresa['V_URL_FB'])): ?>
					<a href="<?php echo h($empresa['V_URL_FB']); ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
				<?php endif; ?>
				<?php if (!empty($empresa['V_URL_IG'])): ?>
					<a href="<?php echo h($empresa['V_URL_IG']); ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
				<?php endif; ?>
				<?php if (!empty($empresa['V_URL_TK'])): ?>
					<a href="<?php echo h($empresa['V_URL_TK']); ?>" target="_blank" rel="noopener" aria-label="TikTok"><i class="fa fa-music" aria-hidden="true"></i></a>
				<?php endif; ?>
				<?php if (!empty($empresa['V_URL_YT'])): ?>
					<a href="<?php echo h($empresa['V_URL_YT']); ?>" target="_blank" rel="noopener" aria-label="YouTube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
				<?php endif; ?>
				<?php if (!empty($empresa['V_URL_TW'])): ?>
					<a href="<?php echo h($empresa['V_URL_TW']); ?>" target="_blank" rel="noopener" aria-label="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
				<?php endif; ?>
			</div>
			<?php if (!empty($empresa_movil)): ?>
				<a class="btn btn--whatsapp" href="<?php echo h(f_whatsapp($empresa_movil, 'Hola, quisiera más información sobre ' . $empresa_nombre)); ?>" target="_blank" rel="noopener">
					<i class="fa fa-whatsapp" aria-hidden="true"></i> Escríbenos
				</a>
			<?php endif; ?>
		</div>
	</div>

	<div class="site-footer__bottom">
		<div class="container">
			<p>&copy; <?php echo date('Y'); ?> <?php echo h($empresa_nombre); ?>. Todos los derechos reservados.</p>
		</div>
	</div>
</footer>

<?php if (!empty($empresa_movil)): ?>
	<div class="chat-flotante">
		<div class="chat-flotante__globo">
			¿Tienes dudas? Escríbenos y te respondemos al toque.
		</div>
		<a
			class="chat-flotante__boton"
			href="<?php echo h(f_whatsapp($empresa_movil, 'Hola, quisiera información sobre ' . $empresa_nombre)); ?>"
			target="_blank"
			rel="noopener"
			aria-label="Chatear por WhatsApp"
		>
			<i class="fa fa-whatsapp" aria-hidden="true"></i>
		</a>
	</div>
<?php endif; ?>

<script src="js/main.js"></script>
</body>
</html>
