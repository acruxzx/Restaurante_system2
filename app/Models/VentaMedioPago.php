<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaMedioPago extends Model
{
    protected $table = 'venta_medio_pago';

    protected $fillable = ['venta_id', 'id_medio_pago', 'monto'];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function medioPago()
{
    return $this->belongsTo(MedioPago::class, 'id_medio_pago');
}

 
}


