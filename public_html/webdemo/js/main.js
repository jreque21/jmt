(function () {
	'use strict';

	// Menú móvil
	var toggle = document.getElementById('navToggle');
	var nav = document.getElementById('navPrincipal');

	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			var abierto = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', abierto ? 'true' : 'false');
			toggle.classList.toggle('is-active', abierto);
		});

		// Cerrar el menú al elegir un enlace (útil en móvil)
		var enlaces = nav.querySelectorAll('a');
		for (var i = 0; i < enlaces.length; i++) {
			enlaces[i].addEventListener('click', function () {
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
				toggle.classList.remove('is-active');
			});
		}
	}

	// Header con sombra al hacer scroll
	var header = document.querySelector('.site-header');
	if (header) {
		var onScroll = function () {
			if (window.scrollY > 8) {
				header.classList.add('is-scrolled');
			} else {
				header.classList.remove('is-scrolled');
			}
		};
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
	}

	// Animación simple al entrar en viewport
	var animables = document.querySelectorAll('[data-animar]');
	if ('IntersectionObserver' in window && animables.length) {
		var observer = new IntersectionObserver(function (entradas) {
			entradas.forEach(function (entrada) {
				if (entrada.isIntersecting) {
					entrada.target.classList.add('en-vista');
					observer.unobserve(entrada.target);
				}
			});
		}, { threshold: 0.15 });

		animables.forEach(function (el) {
			observer.observe(el);
		});
	} else {
		animables.forEach(function (el) {
			el.classList.add('en-vista');
		});
	}

	// Validación básica del formulario de contacto (refuerza la del servidor)
	var formContacto = document.getElementById('formContacto');
	if (formContacto) {
		formContacto.addEventListener('submit', function (evento) {
			var nombre = formContacto.querySelector('[name="nombre"]');
			var email = formContacto.querySelector('[name="email"]');
			var mensaje = formContacto.querySelector('[name="mensaje"]');
			var valido = true;

			[nombre, email, mensaje].forEach(function (campo) {
				if (campo && !campo.value.trim()) {
					campo.classList.add('is-invalid');
					valido = false;
				} else if (campo) {
					campo.classList.remove('is-invalid');
				}
			});

			if (email && email.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
				email.classList.add('is-invalid');
				valido = false;
			}

			if (!valido) {
				evento.preventDefault();
			}
		});
	}

	// Chat flotante: muestra el globo de texto un momento tras cargar la página
	var globo = document.querySelector('.chat-flotante__globo');
	if (globo) {
		setTimeout(function () {
			globo.classList.add('es-visible');
			setTimeout(function () {
				globo.classList.remove('es-visible');
			}, 6000);
		}, 2500);
	}
})();
