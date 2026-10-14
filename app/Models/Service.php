<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Servicio que ofrece STEV (Traslado de valores, Recolección de efectivo, Custodia de valores, ...) */
#[Fillable(['nombre', 'orden', 'activo'])]
class Service extends Model
{
    protected function casts(): array
    {
        return ['activo' => 'boolean'];
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function scopeActivos(Builder $q): Builder
    {
        return $q->where('activo', true)->orderBy('orden')->orderBy('id');
    }
}
