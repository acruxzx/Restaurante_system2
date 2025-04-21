<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Venta
 *
 * @property $id
 * @property $venta
 * @property $id_medioPago
 * @property $id_caja
 * @property $id_productoPedido
 * @property $total
 * @property $created_at
 * @property $updated_at
 *
 * @property MedioPago $medioPago
 * @property MedioPago $medioPago
 * @property ProductoPedido $productoPedido
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Venta extends Model
{
    
    protected $perPage = 20;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_caja',
        'total',
        'id_pedido',
        'turno'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function caja()
    {
        return $this->belongsTo(\App\Models\NumCaja::class, 'id_caja', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mediosDePago()
    {
        return $this->hasMany(VentaMedioPago::class);
    }
    // En el modelo Venta.php
    public function mediosPago()
    {
        return $this->belongsToMany(MedioPago::class, 'venta_medio_pago', 'venta_id', 'id_medio_pago')
         ->withPivot('monto')
        ->withTimestamps();;
    }
    public function ventaMedioPago()
{
    return $this->hasMany(VentaMedioPago::class, 'venta_id');
}


    
      
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pedido()
{
    return $this->belongsTo(Pedido::class, 'id_pedido', 'id');
}

    
}
