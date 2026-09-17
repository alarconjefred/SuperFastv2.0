<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','precio','empresa_id'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}