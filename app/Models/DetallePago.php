<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePago extends Model
{
    use HasFactory;

    protected $table = 'detalle_pagos'; // Nombre de la tabla
    protected $fillable = ['venta_id', 'medio_pago', 'monto'];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
