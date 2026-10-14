// Panel administrativo
import 'bootstrap/js/dist/collapse';

document.addEventListener('DOMContentLoaded', () => {
    // --- Filtros: mostrar fechas solo en "Personalizado" y aplicar al elegir periodo ---
    const form = document.getElementById('filtros');
    if (form) {
        const rangos = form.querySelectorAll('.rango-fechas');
        form.querySelectorAll('input[name="periodo"]').forEach((radio) => {
            radio.addEventListener('change', () => {
                const personalizado = radio.value === 'personalizado';
                rangos.forEach((r) => { r.hidden = !personalizado; });
                if (personalizado) {
                    form.querySelector('input[name="desde"]')?.focus();
                } else {
                    form.requestSubmit();
                }
            });
        });
    }

    // --- Filtros de sucursal / interés: se aplican al elegir ---
    document.querySelectorAll('[data-autoenviar]').forEach((sel) => {
        sel.addEventListener('change', () => sel.form?.requestSubmit());
    });

    // --- Tabla: toda la fila abre el prospecto ---
    document.querySelectorAll('tr[data-href]').forEach((tr) => {
        tr.addEventListener('click', (e) => {
            if (e.target.closest('a, button')) return;
            window.location = tr.dataset.href;
        });
    });
});
