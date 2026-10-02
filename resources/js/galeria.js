document.addEventListener('DOMContentLoaded', function () {

    const galeria = document.querySelector('.galeria');
    const track = document.querySelector('.galeria-track');

    if (!galeria || !track) return;

    const originales = Array.from(track.children);
    if (!originales.length) return;

    /*
    ==========================================
    GALERÍA INFINITA
    ==========================================
    */

    let anchoGrupo = 0;

    function construir() {

        // Quitamos las copias anteriores (por si cambió el tamaño)
        track.querySelectorAll('.galeria-clon').forEach(el => el.remove());

        // Siempre al menos UNA copia completa del grupo,
        // y las que hagan falta para cubrir la pantalla
        do {
            originales.forEach(item => {
                const copia = item.cloneNode(true);
                copia.classList.add('galeria-clon');
                copia.setAttribute('aria-hidden', 'true');
                track.appendChild(copia);
            });

            anchoGrupo = track.children[originales.length].offsetLeft
                       - track.children[0].offsetLeft;

        } while (track.scrollWidth < anchoGrupo + window.innerWidth * 2);
    }

    construir();

    /*
    ==========================================
    MOVIMIENTO
    ==========================================
    */

    let posicion = 0;
    let ultimoTiempo = performance.now();
    let pausado = false;

    const velocidad = 45; // píxeles por segundo

    function moverGaleria(tiempo) {

        // Limitamos el salto si la pestaña estuvo en segundo plano
        const delta = Math.min(tiempo - ultimoTiempo, 100);
        ultimoTiempo = tiempo;

        if (!pausado && anchoGrupo > 0) {

            posicion -= velocidad * (delta / 1000);

            // Módulo: nunca se sale del rango, aunque haya avanzado mucho
            if (posicion <= -anchoGrupo) {
                posicion = posicion % anchoGrupo;
            }

            track.style.transform = `translate3d(${posicion}px, 0, 0)`;
        }

        requestAnimationFrame(moverGaleria);
    }

    requestAnimationFrame(moverGaleria);

    /*
    ==========================================
    PAUSAR CON MOUSE (solo mouse real, no touch)
    ==========================================
    */

    galeria.addEventListener('pointerenter', function (e) {
        if (e.pointerType === 'mouse') pausado = true;
    });

    galeria.addEventListener('pointerleave', function (e) {
        if (e.pointerType === 'mouse') pausado = false;
    });

    /*
    ==========================================
    LIGHTBOX
    ==========================================
    */

    const lightbox = document.getElementById('galeriaLightbox');
    const lightboxImg = document.getElementById('galeriaLightboxImg');
    const close = document.querySelector('.galeria-close');

    if (lightbox && lightboxImg) {

        track.addEventListener('click', function (e) {
            const img = e.target.closest('img');
            if (!img) return;

            lightboxImg.src = img.src;
            lightbox.classList.add('active');
            pausado = true;
            document.body.style.overflow = 'hidden';
        });

        function cerrarLightbox() {
            if (!lightbox.classList.contains('active')) return;

            lightbox.classList.remove('active');
            document.body.style.overflow = '';
            pausado = false;

            setTimeout(function () {
                lightboxImg.src = '';
            }, 300);
        }

        if (close) close.addEventListener('click', cerrarLightbox);

        lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox) cerrarLightbox();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') cerrarLightbox();
        });
    }

    /*
    ==========================================
    RESIZE / ROTAR EL CELULAR
    ==========================================
    */

    let resizeTimer;

    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            construir();
            posicion = posicion % anchoGrupo;
        }, 200);
    });

});

document.addEventListener('DOMContentLoaded', () => {

    const contenedor = document.querySelector('.datosduros');

    if (!contenedor) return;

    let velocidad = 0.5;
    let pausado = false;

    function mover() {

        if (!pausado) {
            contenedor.scrollLeft += velocidad;

            // Cuando llega al final, vuelve al inicio
            if (
                contenedor.scrollLeft + contenedor.clientWidth >=
                contenedor.scrollWidth
            ) {
                contenedor.scrollLeft = 0;
            }
        }

        requestAnimationFrame(mover);
    }

    // Pausar al poner el mouse encima
    contenedor.addEventListener('mouseenter', () => {
        pausado = true;
    });

    contenedor.addEventListener('mouseleave', () => {
        pausado = false;
    });

    // Pausar mientras el usuario toca/desliza
    contenedor.addEventListener('touchstart', () => {
        pausado = true;
    });

    contenedor.addEventListener('touchend', () => {
        pausado = false;
    });

    mover();
});

document.addEventListener('DOMContentLoaded', function () {

    const navbar = document.querySelector('.navbar-principal');
    const header = document.querySelector('#inicio');

    if (!navbar || !header) return;

    function checkScroll() {

        const headerHeight = header.offsetHeight;

        if (window.scrollY > headerHeight) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }

    }

    window.addEventListener('scroll', checkScroll);

    checkScroll();

});