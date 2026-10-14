<?php

namespace App\Enums;

/** Tipo de registro en el historial de un prospecto */
enum ActivityType: string
{
    case Contacto = 'contacto';      // contacto con el prospecto / cambio de estado
    case Interes = 'interes';        // cambio de servicio de interés
    case Sistema = 'sistema';        // registro automático

    public function label(): string
    {
        return match ($this) {
            self::Contacto => 'Contacto',
            self::Interes => 'Interés',
            self::Sistema => 'Sistema',
        };
    }
}
