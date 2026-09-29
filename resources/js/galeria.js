document.addEventListener('DOMContentLoaded', function () {

    const galeria = document.querySelector('.galeria');
    const track = document.querySelector('.galeria-track');

    if (!galeria || !track) return;


    /*
    ==========================================
    GALERÍA INFINITA
    ==========================================
    */

    // Guardamos las imágenes originales
    const originales = Array.from(track.children);

    if (!originales.length) return;


    // Creamos suficientes copias
    // para llenar varias veces la pantalla

    let anchoNecesario = window.innerWidth * 3;

    while (track.scrollWidth < anchoNecesario) {

        originales.forEach(item => {

            const copia = item.cloneNode(true);

            track.appendChild(copia);

        });

    }


    /*
    ==========================================
    CALCULAR ANCHO DEL GRUPO ORIGINAL
    ==========================================
    */

    let anchoGrupo = 0;

    originales.forEach(item => {

        anchoGrupo += item.offsetWidth;

        const estilo = window.getComputedStyle(item);

        anchoGrupo += parseFloat(estilo.marginRight) || 0;

    });


    /*
    ==========================================
    MOVIMIENTO
    ==========================================
    */

    let posicion = 0;

    let ultimoTiempo = performance.now();

    let pausado = false;

    // Velocidad en píxeles por segundo
    const velocidad = 45;


    function moverGaleria(tiempo) {

        const delta = tiempo - ultimoTiempo;

        ultimoTiempo = tiempo;


        if (!pausado) {

            posicion -= velocidad * (delta / 1000);


            /*
            Cuando terminamos un grupo,
            regresamos exactamente al inicio
            del siguiente grupo.
            */

            if (Math.abs(posicion) >= anchoGrupo) {

                posicion += anchoGrupo;

            }


            track.style.transform =
                `translate3d(${posicion}px, 0, 0)`;

        }


        requestAnimationFrame(moverGaleria);

    }


    requestAnimationFrame(moverGaleria);


    /*
    ==========================================
    PAUSAR CON MOUSE
    ==========================================
    */

    galeria.addEventListener('mouseenter', function () {

        pausado = true;

    });


    galeria.addEventListener('mouseleave', function () {

        pausado = false;

        ultimoTiempo = performance.now();

    });


    /*
    ==========================================
    LIGHTBOX
    ==========================================
    */

    const lightbox =
        document.getElementById('galeriaLightbox');

    const lightboxImg =
        document.getElementById('galeriaLightboxImg');

    const close =
        document.querySelector('.galeria-close');


    /*
    Delegación de eventos:
    funciona con las imágenes originales
    y con todas las copias.
    */

    track.addEventListener('click', function (e) {

        const img = e.target.closest('img');

        if (!img) return;


        lightboxImg.src = img.src;

        lightbox.classList.add('active');

        // Pausamos la galería
        pausado = true;

        // Bloqueamos el scroll del documento
        document.body.style.overflow = 'hidden';

    });


    function cerrarLightbox() {

        lightbox.classList.remove('active');

        document.body.style.overflow = '';

        pausado = false;

        ultimoTiempo = performance.now();

        setTimeout(function () {

            lightboxImg.src = '';

        }, 300);

    }


    close.addEventListener('click', cerrarLightbox);


    /*
    Cerrar haciendo click
    fuera de la imagen
    */

    lightbox.addEventListener('click', function (e) {

        if (e.target === lightbox) {

            cerrarLightbox();

        }

    });


    /*
    ESC
    */

    document.addEventListener('keydown', function (e) {

        if (e.key === 'Escape') {

            cerrarLightbox();

        }

    });


    /*
    ==========================================
    RESIZE
    ==========================================
    */

    window.addEventListener('resize', function () {

        /*
        No necesitamos recalcular el movimiento
        mientras no cambie el ancho de las imágenes.
        */

        if (posicion <= -anchoGrupo) {

            posicion = 0;

        }

    });

});