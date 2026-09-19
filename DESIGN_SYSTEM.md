# DESIGN_SYSTEM.md

## 1. PROPÓSITO

Este documento define las reglas visuales del proyecto.

Claude Code debe consultar este documento antes de crear o modificar componentes visuales.

El objetivo es mantener una identidad visual consistente en todas las páginas.

---

## 2. PRINCIPIOS DE DISEÑO

La interfaz debe transmitir:

- Profesionalismo
- Modernidad
- Claridad
- Confianza
- Simplicidad
- Calidad tecnológica

Evitar apariencia de plantilla genérica.

Cada elemento visual debe tener una función.

---

## 3. LAYOUT

Utilizar un sistema de contenido consistente.

Recomendación:

```css
.container {
  width: min(100% - 2rem, 1200px);
  margin-inline: auto;
}
```

En desktop puede utilizarse un ancho máximo de aproximadamente 1200–1280px según el contenido.

No utilizar contenido excesivamente ancho.

---

## 4. ESPACIADO

Utilizar una escala consistente.

Ejemplo:

```text
4px
8px
12px
16px
24px
32px
48px
64px
80px
96px
120px
```

Evitar valores aleatorios cuando exista un valor cercano en la escala.

---

## 5. TIPOGRAFÍA

Fuente principal recomendada:

```text
Inter
```

Alternativas:

```text
Manrope
Plus Jakarta Sans
DM Sans
Poppins
```

### Jerarquía

H1:
- grande
- fuerte
- máximo impacto visual

H2:
- claramente diferenciable
- utilizado para títulos de sección

H3:
- títulos de cards y subsecciones

Body:
- cómodo de leer
- line-height aproximado de 1.5–1.7

No utilizar demasiados pesos tipográficos.

---

## 6. COLORES

Definir la paleta específica del proyecto antes de implementar el diseño final.

Estructura recomendada:

```css
:root {
  --color-primary: #000000;
  --color-primary-hover: #000000;

  --color-secondary: #000000;

  --color-accent: #000000;

  --color-background: #ffffff;
  --color-surface: #f8fafc;

  --color-text: #111827;
  --color-text-muted: #6b7280;

  --color-border: #e5e7eb;

  --color-success: #16a34a;
  --color-warning: #d97706;
  --color-error: #dc2626;
}
```

Los valores anteriores son placeholders de arquitectura visual y deben reemplazarse por la paleta definitiva del proyecto.

No introducir nuevos colores sin justificación.

---

## 7. BOTONES

Los botones deben tener:

- altura adecuada
- padding consistente
- border radius coherente
- estados hover
- estado focus
- estado disabled
- transición suave

Tipos:

### Primary

Para la acción principal.

### Secondary

Para acciones secundarias.

### Ghost

Para acciones de baja prioridad.

No utilizar demasiados estilos de botón.

---

## 8. CARDS

Las cards deben utilizar:

- padding consistente
- border radius uniforme
- borde o sombra sutil
- jerarquía clara

Evitar sombras exageradas.

Ejemplo:

```css
.card {
  border-radius: 16px;
  border: 1px solid var(--color-border);
  background: var(--color-background);
}
```

---

## 9. BORDER RADIUS

Escala recomendada:

```text
4px   → elementos pequeños
8px   → controles
12px  → componentes
16px  → cards
24px  → elementos destacados
```

No mezclar demasiados radios.

---

## 10. SOMBRAS

Utilizar sombras sutiles.

Preferir profundidad mediante:

1. contraste
2. borde
3. superficie
4. sombra ligera

Evitar interfaces con sombras fuertes en todos los componentes.

---

## 11. ICONOGRAFÍA

Utilizar una única familia de iconos.

Los iconos deben:

- tener pesos consistentes
- tener tamaños coherentes
- estar alineados correctamente

No utilizar emojis como iconografía principal.

---

## 12. IMÁGENES

Las imágenes deben tener:

- buena calidad
- relación de aspecto consistente
- tratamiento visual coherente

Utilizar:

```text
WebP
AVIF
SVG
```

cuando corresponda.

No utilizar imágenes decorativas sin propósito.

---

## 13. HERO

El Hero debe comunicar:

1. Qué es el producto/servicio.
2. Qué beneficio ofrece.
3. Qué acción debe realizar el usuario.

Debe contener, cuando corresponda:

- eyebrow
- H1
- descripción
- CTA
- visual principal

No sobrecargar el Hero.

---

## 14. SECCIONES

Cada sección debe tener:

- título
- contexto
- contenido
- separación visual

Mantener ritmo vertical consistente.

Evitar demasiadas secciones consecutivas con la misma estructura.

---

## 15. ANIMACIONES

Utilizar transiciones entre:

```text
150ms – 250ms
```

para microinteracciones.

Las animaciones de entrada pueden ser ligeramente mayores.

Evitar animaciones lentas que hagan sentir lenta la interfaz.

---

## 16. RESPONSIVE

Breakpoints recomendados:

```text
640px
768px
1024px
1280px
1536px
```

No depender exclusivamente de estos valores.

Utilizar diseño fluido cuando sea apropiado.

---

## 17. MOBILE

En mobile:

- priorizar contenido
- reducir elementos secundarios
- utilizar navegación compacta
- aumentar área táctil
- evitar texto demasiado pequeño
- evitar grids de demasiadas columnas

---

## 18. ACCESIBILIDAD

Mantener:

- contraste adecuado
- focus visible
- navegación por teclado
- tamaño táctil adecuado
- textos legibles
- labels
- alt text

No comunicar información únicamente mediante color.

---

## 19. CONSISTENCIA

Antes de crear un nuevo componente visual, comprobar si ya existe uno reutilizable.

No crear:

```text
Button
PrimaryButton
MainButton
CTAButton
SpecialButton
```

si todos cumplen esencialmente la misma función.

Crear una única abstracción cuando sea razonable.

---

## 20. REGLA DE CALIDAD

Antes de aprobar una interfaz, comprobar:

### Visual
- ¿Existe jerarquía?
- ¿Existe suficiente espacio?
- ¿Los colores son consistentes?
- ¿La tipografía funciona?
- ¿Las imágenes tienen calidad?

### UX
- ¿Es intuitiva?
- ¿Los CTA son claros?
- ¿El usuario sabe qué hacer?

### Responsive
- ¿Funciona en mobile?
- ¿Funciona en tablet?
- ¿Funciona en desktop?

### Accesibilidad
- ¿Se puede navegar con teclado?
- ¿Existe focus visible?
- ¿El contraste es adecuado?

### Performance
- ¿Las imágenes están optimizadas?
- ¿Existen recursos innecesarios?

---

## 21. REGLA FINAL

La interfaz debe sentirse:

**moderna + profesional + limpia + rápida + coherente**

No buscar modernidad mediante exceso de efectos.

La calidad debe provenir principalmente de:

- composición
- tipografía
- espaciado
- color
- jerarquía
- consistencia
- interacción
- contenido
