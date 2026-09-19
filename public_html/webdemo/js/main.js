(function () {
	'use strict';

	// Modo oscuro / claro
	var botonTema = document.getElementById('themeToggle');
	function actualizarIconoTema() {
		if (!botonTema) return;
		var icono = botonTema.querySelector('i');
		var esOscuro = document.documentElement.getAttribute('data-theme') === 'oscuro';
		if (icono) {
			icono.className = esOscuro ? 'fa fa-sun-o' : 'fa fa-moon-o';
		}
		botonTema.setAttribute('aria-label', esOscuro ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro');
	}
	if (botonTema) {
		actualizarIconoTema();
		botonTema.addEventListener('click', function () {
			var esOscuro = document.documentElement.getAttribute('data-theme') === 'oscuro';
			if (esOscuro) {
				document.documentElement.removeAttribute('data-theme');
			} else {
				document.documentElement.setAttribute('data-theme', 'oscuro');
			}
			try { localStorage.setItem('tema', esOscuro ? 'claro' : 'oscuro'); } catch (e) {}
			actualizarIconoTema();
		});
	}

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
				return;
			}

			// Certificado de bienvenida en PDF, generado en el navegador con el
			// nombre que la persona acaba de escribir (no se inventa ningún dato).
			try {
				if (window.jspdf && window.jspdf.jsPDF && nombre && nombre.value.trim()) {
					generarCertificadoBienvenida(nombre.value.trim(), formContacto.getAttribute('data-empresa') || '');
				}
			} catch (e) {
				// Si jsPDF no cargó a tiempo, el formulario sigue su envío normal.
			}
		});
	}

	function generarCertificadoBienvenida(nombreCompleto, nombreEmpresa) {
		var jsPDF = window.jspdf.jsPDF;
		var doc = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });
		var ancho = doc.internal.pageSize.getWidth();
		var alto = doc.internal.pageSize.getHeight();

		doc.setDrawColor(200, 16, 46);
		doc.setLineWidth(2);
		doc.rect(8, 8, ancho - 16, alto - 16);
		doc.setLineWidth(0.5);
		doc.rect(12, 12, ancho - 24, alto - 24);

		doc.setTextColor(20, 20, 20);
		doc.setFont('helvetica', 'bold');
		doc.setFontSize(14);
		doc.text((nombreEmpresa || 'Academia de Taekwondo').toUpperCase(), ancho / 2, 32, { align: 'center' });

		doc.setFontSize(26);
		doc.setTextColor(200, 16, 46);
		doc.text('CERTIFICADO DE BIENVENIDA', ancho / 2, 50, { align: 'center' });

		doc.setFont('helvetica', 'normal');
		doc.setFontSize(12);
		doc.setTextColor(60, 60, 60);
		doc.text('Se otorga el presente certificado a:', ancho / 2, 68, { align: 'center' });

		doc.setFont('helvetica', 'bold');
		doc.setFontSize(22);
		doc.setTextColor(20, 20, 20);
		doc.text(nombreCompleto, ancho / 2, 84, { align: 'center' });

		doc.setFont('helvetica', 'normal');
		doc.setFontSize(12);
		doc.setTextColor(60, 60, 60);
		var mensaje = 'por dar el primer paso hacia su camino en el Taekwondo. Bienvenido(a) a nuestra comunidad.';
		doc.text(mensaje, ancho / 2, 96, { align: 'center', maxWidth: ancho - 60 });

		var fecha = new Date().toLocaleDateString('es-PE', { year: 'numeric', month: 'long', day: 'numeric' });
		doc.setFontSize(10);
		doc.text('Emitido el ' + fecha, ancho / 2, alto - 20, { align: 'center' });

		doc.save('certificado-bienvenida.pdf');
	}

	// Carrusel de fotos
	var carruselPista = document.getElementById('carruselPista');
	if (carruselPista) {
		var slides = Array.prototype.slice.call(carruselPista.children);
		var puntosCont = document.getElementById('carruselPuntos');
		var indiceActual = 0;
		var autoplayId = null;

		slides.forEach(function (_, i) {
			var punto = document.createElement('button');
			punto.type = 'button';
			punto.className = 'carrusel__punto' + (i === 0 ? ' es-activo' : '');
			punto.setAttribute('aria-label', 'Ir a la foto ' + (i + 1));
			punto.addEventListener('click', function () { irASlide(i); });
			if (puntosCont) puntosCont.appendChild(punto);
		});

		function irASlide(indice) {
			indiceActual = (indice + slides.length) % slides.length;
			carruselPista.style.transform = 'translateX(-' + (indiceActual * 100) + '%)';
			if (puntosCont) {
				Array.prototype.forEach.call(puntosCont.children, function (punto, i) {
					punto.classList.toggle('es-activo', i === indiceActual);
				});
			}
		}

		function reiniciarAutoplay() {
			if (autoplayId) clearInterval(autoplayId);
			autoplayId = setInterval(function () { irASlide(indiceActual + 1); }, 5000);
		}

		var btnAnterior = document.getElementById('carruselAnterior');
		var btnSiguiente = document.getElementById('carruselSiguiente');
		if (btnAnterior) btnAnterior.addEventListener('click', function () { irASlide(indiceActual - 1); reiniciarAutoplay(); });
		if (btnSiguiente) btnSiguiente.addEventListener('click', function () { irASlide(indiceActual + 1); reiniciarAutoplay(); });

		if (slides.length > 1) reiniciarAutoplay();
	}

	// Calculadora de progreso de cinturón
	var selectCinturon = document.getElementById('selectCinturon');
	if (selectCinturon) {
		var barraCinturon = document.getElementById('barraCinturon');
		var textoCinturon = document.getElementById('textoResultadoCinturon');
		var totalGrados = parseInt(selectCinturon.getAttribute('data-total-grados'), 10) || 1;

		function actualizarCalculadora() {
			var actual = parseInt(selectCinturon.value, 10) || 1;
			var faltan = totalGrados - actual;
			var porcentaje = Math.round((actual / totalGrados) * 100);
			if (barraCinturon) barraCinturon.style.width = porcentaje + '%';
			if (textoCinturon) {
				if (faltan <= 0) {
					textoCinturon.innerHTML = '¡Felicidades! Ya alcanzaste el <strong>último grado</strong> de nuestro sistema.';
				} else {
					textoCinturon.innerHTML = 'Te faltan <strong>' + faltan + ' grado' + (faltan === 1 ? '' : 's') + '</strong> para llegar al cinturón negro (' + porcentaje + '% del camino recorrido). El tiempo exacto depende de tu constancia y asistencia — consúltanos para un plan personalizado.';
				}
			}
		}

		selectCinturon.addEventListener('change', actualizarCalculadora);
		actualizarCalculadora();
	}

	// Asistente de preguntas frecuentes (respuestas predefinidas, no es chat humano)
	var faqBoton = document.getElementById('faqBoton');
	var faqPanel = document.getElementById('faqPanel');
	var faqCerrar = document.getElementById('faqCerrar');
	var faqCuerpo = document.getElementById('faqCuerpo');
	var faqListaPreguntas = document.getElementById('faqListaPreguntas');

	var preguntasFrecuentes = [
		{
			pregunta: '¿Qué es el Taekwondo?',
			respuesta: 'Es un arte marcial coreano y deporte olímpico que combina técnicas de golpeo con manos y pies, condición física y valores como el respeto y la disciplina. Puedes leer más en la sección "Nosotros".'
		},
		{
			pregunta: '¿Qué sedes tienen?',
			respuesta: 'Contamos con varias sedes en Chachapoyas. Revisa la dirección y contacto de cada una en la página <a href="sedes.php">Sedes</a>.'
		},
		{
			pregunta: '¿Cuáles son los horarios de clases?',
			respuesta: 'Los horarios vigentes por sede, día y turno están publicados en la página <a href="horarios.php">Horarios</a>.'
		},
		{
			pregunta: '¿Dan clases para niños y adultos?',
			respuesta: 'Sí, tenemos clases para niños, adolescentes, damas y varones. Cada grupo entrena según su edad y nivel.'
		},
		{
			pregunta: '¿Qué medios de pago aceptan?',
			respuesta: 'Aceptamos tarjeta de crédito/débito, Yape, Plin, transferencia bancaria y efectivo en sede.'
		},
		{
			pregunta: '¿Cómo me inscribo?',
			respuesta: 'Escríbenos por el formulario de <a href="contacto.php">Contacto</a> o directamente por WhatsApp, indicando la sede y el horario de tu interés, y te ayudamos con el proceso de inscripción.'
		}
	];

	function mostrarListaPreguntas() {
		if (!faqListaPreguntas) return;
		faqListaPreguntas.innerHTML = '';
		preguntasFrecuentes.forEach(function (item, indice) {
			var boton = document.createElement('button');
			boton.type = 'button';
			boton.className = 'faq-panel__pregunta';
			boton.textContent = item.pregunta;
			boton.addEventListener('click', function () {
				mostrarRespuesta(indice);
			});
			faqListaPreguntas.appendChild(boton);
		});
	}

	function mostrarRespuesta(indice) {
		if (!faqCuerpo) return;
		var item = preguntasFrecuentes[indice];
		faqCuerpo.innerHTML =
			'<p class="faq-panel__respuesta">' + item.respuesta + '</p>' +
			'<button type="button" class="faq-panel__volver" id="faqVolver"><i class="fa fa-angle-left" aria-hidden="true"></i> Ver otras preguntas</button>';
		var volver = document.getElementById('faqVolver');
		if (volver) {
			volver.addEventListener('click', function () {
				faqCuerpo.innerHTML = '<p class="faq-panel__intro">Elige una pregunta:</p><div class="faq-panel__preguntas" id="faqListaPreguntas"></div>';
				faqListaPreguntas = document.getElementById('faqListaPreguntas');
				mostrarListaPreguntas();
			});
		}
	}

	if (faqBoton && faqPanel) {
		faqBoton.addEventListener('click', function () {
			var abierto = faqPanel.hasAttribute('hidden') === false;
			if (abierto) {
				faqPanel.setAttribute('hidden', '');
				faqBoton.setAttribute('aria-expanded', 'false');
			} else {
				faqPanel.removeAttribute('hidden');
				faqBoton.setAttribute('aria-expanded', 'true');
				mostrarListaPreguntas();
			}
		});
	}
	if (faqCerrar && faqPanel) {
		faqCerrar.addEventListener('click', function () {
			faqPanel.setAttribute('hidden', '');
			if (faqBoton) faqBoton.setAttribute('aria-expanded', 'false');
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
