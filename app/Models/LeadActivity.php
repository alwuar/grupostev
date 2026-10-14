<?php

namespace App\Models;

use App\Enums\ActivityType;
use App\Enums\ContactMedium;
use App\Enums\LeadStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['lead_id', 'user_id', 'tipo', 'estado_anterior', 'estado', 'asunto', 'medio', 'nota'])]
class LeadActivity extends Model
{
    protected function casts(): array
    {
        return [
            'tipo' => ActivityType::class,
            'estado' => LeadStatus::class,
            'estado_anterior' => LeadStatus::class,
            'medio' => ContactMedium::class,
        ];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cambioEstado(): bool
    {
        return $this->estado_anterior !== null && $this->estado_anterior !== $this->estado;
    }

    /** "Registrado por: Ana" / "Sistema" */
    public function autor(): string
    {
        return $this->user?->name ?? 'Sistema';
    }
}
