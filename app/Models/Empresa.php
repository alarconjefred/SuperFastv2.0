<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
    'nombre',
    'direccion',
    'user_id',
];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * URL del logo o fallback institucional para la empresa
     */
    public function getLogoUrlAttribute(): string
    {
        return asset('img/Iconos/Version compacta.jpg');
    }

    /**
     * Iniciales para avatares visuales
     */
    public function getInicialesAttribute(): string
    {
        $palabras = explode(' ', trim($this->nombre ?? 'Empresa'));
        if (count($palabras) >= 2) {
            return mb_strtoupper(mb_substr($palabras[0], 0, 1) . mb_substr($palabras[1], 0, 1));
        }
        return mb_strtoupper(mb_substr($this->nombre ?? 'E', 0, 2));
    }
}