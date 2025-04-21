<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pedido
 *
 * @property $id
 * @property $pedido
 * @property $entrega
 * @property $id_trabajador
 * @property $id_cliente
 * @property $id_estadoPedido
 * @property $id_tp_pedido
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @property EstadoPedido $estadoPedido
 * @property TpPedido $tpPedido
 * @property User $user
 * @property ProductoPedido[] $productoPedidos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Pedido extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['pedido', 'id_trabajador', 'id_cliente', 'id_estadoPedido', 'id_tp_pedido'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo(\App\Models\cliente::class, 'id_cliente', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadoPedido()
    {
        return $this->belongsTo(\App\Models\EstadoPedido::class, 'id_estadoPedido', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tpPedido()
    {
        return $this->belongsTo(\App\Models\TpPedido::class, 'id_tp_pedido', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userTrabajador()
    {
        return $this->belongsTo(\App\Models\Trabajadore::class, 'id_trabajador', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productoPedidos()
    {
        return $this->hasMany(\App\Models\ProductoPedido::class, 'id_pedido', 'id');
    }

    public function venta()
{
    return $this->hasOne(Venta::class, 'id_pedido', 'id');
}


}
