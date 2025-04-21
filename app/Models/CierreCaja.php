<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CierreCaja extends Model
{
    use HasFactory;
    protected $table = 'cierres_caja';

    protected $fillable = [
        'id_caja',
        'turno',
        'fecha',
        'monto_inicial',
        'monto_final',
        'total_ventas',
    ];
}
