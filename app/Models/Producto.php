<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'imagen',
        'stock',
        'disponible',
        'empresa_id',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'disponible' => 'boolean',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Obtiene la URL completa de la imagen del producto con fallback institucional
     */
    public function getImagenUrlAttribute(): string
    {
        if ($this->imagen && Storage::disk('public')->exists($this->imagen)) {
            return asset('storage/' . $this->imagen);
        }

        // Fallback institucional en caso de no tener imagen personalizada
        return asset('img/Iconos/Version compacta.jpg');
    }

    /**
     * Determina si el producto está agotado
     */
    public function getEstaAgotadoAttribute(): bool
    {
        return !$this->disponible || $this->stock <= 0;
    }
}