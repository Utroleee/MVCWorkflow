<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'prioridad',
        'estado',
        'categoria',
        'cliente_id',
        'tecnico_id',
    ];

    /**
     * Obtiene el cliente que creó el ticket.
     */
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    /**
     * Obtiene el técnico asignado al ticket.
     */
    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }
}