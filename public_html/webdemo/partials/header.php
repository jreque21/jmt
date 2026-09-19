<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo h($meta_titulo); ?></title>
	<meta name="description" content="<?php echo h($meta_descripcion); ?>">

	<!-- Open Graph -->
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?php echo h($meta_titulo); ?>">
	<meta property="og:description" content="<?php echo h($meta_descripcion); ?>">
	<meta property="og:image" content="<?php echo h($empresa_logo); ?>">
	<meta property="og:locale" content="es_PE">

	<link rel="canonical" href="<?php echo h('https://www.jmtalentgroup.com/webdemo/' . basename($_SERVER['PHP_SELF'])); ?>">
	<link rel="shortcut icon" href="recursos/images/favicon.ico" type="image/x-icon">

	<!-- Tipografía -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

	<!-- Iconos (una sola familia, ver DESIGN_SYSTEM.md) -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="css/style.css">
</head>
<body>

<a class="skip-link" href="#contenido">Saltar al contenido</a>

<div class="topbar">
	<div class="container topbar__inner">
		<span class="topbar__msg">
			<i class="fa fa-bullhorn" aria-hidden="true"></i>
			Promociones vigentes y graduaciones de cinturón durante todo el año
		</span>
		<a href="contacto.php" class="topbar__link">Consultar fechas <i class="fa fa-angle-right" aria-hidden="true"></i></a>
	</div>
</div>

<header class="site-header">
	<div class="container site-header__inner">
		<a href="index.php" class="brand">
			<img src="<?php echo h($empresa_logo); ?>" alt="<?php echo h($empresa_nombre); ?>" class="brand__logo">
			<span class="brand__text">
				<strong><?php echo h($empresa_nombre); ?></strong>
				<small><?php echo h($empresa_lema); ?></small>
			</span>
		</a>

		<button class="nav-toggle" id="navToggle" aria-expanded="false" aria-controls="navPrincipal" aria-label="Abrir menú">
			<span></span><span></span><span></span>
		</button>

		<nav class="nav" id="navPrincipal">
			<a href="index.php"<?php echo ($pagina_actual == 'inicio') ? ' class="is-active"' : ''; ?>>Inicio</a>
			<a href="nosotros.php"<?php echo ($pagina_actual == 'nosotros') ? ' class="is-active"' : ''; ?>>Nosotros</a>
			<a href="instructores.php"<?php echo ($pagina_actual == 'instructores') ? ' class="is-active"' : ''; ?>>Instructores</a>
			<a href="sedes.php"<?php echo ($pagina_actual == 'sedes') ? ' class="is-active"' : ''; ?>>Sedes</a>
			<a href="horarios.php"<?php echo ($pagina_actual == 'horarios') ? ' class="is-active"' : ''; ?>>Horarios</a>
			<a href="contacto.php"<?php echo ($pagina_actual == 'contacto') ? ' class="is-active"' : ''; ?>>Contacto</a>
			<a href="../index.php" class="nav__cta">Acceso Estudiantes</a>
		</nav>
	</div>
</header>
