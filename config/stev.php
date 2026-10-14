<?php

/*
 * Ajustes del sitio y del panel de prospectos de Grupo STEV.
 * Todo se puede cambiar desde el .env sin tocar código.
 */
return [
    /*
     * Correo(s) que reciben un aviso por cada prospecto del formulario.
     * En el .env: PROSPECTOS_CORREO=contacto@stevseguridadprivada.com (varios separados por coma, sin espacios).
     * Si se deja vacío no se envía nada.
     */
    'prospectos' => [
        'correos' => array_values(array_filter(array_map('trim', explode(',', (string) env('PROSPECTOS_CORREO', ''))))),
    ],

    // Datos del responsable para el Aviso de privacidad (/aviso-de-privacidad)
    'privacidad' => [
        // Razón social como aparece en el RFC del cliente
        'responsable' => env('AVISO_RESPONSABLE', 'Grupo STEV Seguridad Privada'),
        'domicilio' => env('AVISO_DOMICILIO', 'Av. Juárez Núm. 2509, Depto. 7, Col. La Paz, C.P. 72160, Puebla, Puebla, México'),
        'correo' => env('AVISO_CORREO', 'contacto@stevseguridadprivada.com'),
        'telefono' => env('AVISO_TELEFONO', '222 761 1338'),
        // Fecha de la última actualización del aviso (cámbiala cada vez que modifiques el texto)
        'actualizado' => env('AVISO_ACTUALIZADO', '2026-10-14'),
    ],
];
