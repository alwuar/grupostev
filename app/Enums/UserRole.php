<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Asesor = 'asesor';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::Asesor => 'Asesor',
        };
    }

    public function descripcion(): string
    {
        return match ($this) {
            self::Admin => 'Ve todo: prospectos, estadísticas, usuarios y servicios.',
            self::Asesor => 'Ve y atiende los prospectos y sus estadísticas. No administra usuarios ni servicios.',
        };
    }
}
