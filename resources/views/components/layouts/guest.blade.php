<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Transporte de valores' }}</title>
    @stack('scss')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');
    </style>
</head>

<body>
    <x-nav />
    <x-whatsapp />

    {{ $slot }}

    <x-footer />

    <script src="https://unpkg.com/lenis@1.3.4/dist/lenis.min.js"></script>

<script>
    const lenis = new Lenis({
        duration: 1.5,
        smoothWheel: true,
        wheelMultiplier: .8,
    });

    function raf(time) {
        lenis.raf(time);
        requestAnimationFrame(raf);
    }

    requestAnimationFrame(raf);

    const elementos = document.querySelectorAll('.scroll-animate');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            } else {
                entry.target.classList.remove('show');
            }
        });
    }, {
        threshold: 0.15
    });

    elementos.forEach(elemento => {
        observer.observe(elemento);
    });
</script>

</body>

</html>
