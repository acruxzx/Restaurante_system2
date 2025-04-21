<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductoPedido
 *
 * @property $id
 * @property $id_precio
 * @property $id_pedido
 * @property $cantidad
 * @property $created_at
 * @property $updated_at
 *
 * @property Pedido $pedido
 * @property Precio $precio
 * @property Venta[] $ventas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ProductoPedido extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id_precio', 'id_pedido', 'cantidad','descuento','observacion'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pedido()
    {
        return $this->belongsTo(\App\Models\Pedido::class, 'id_pedido', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function precio()
    {
        return $this->belongsTo(\App\Models\Precio::class, 'id_precio', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ventas()
    {
        return $this->hasMany(\App\Models\Venta::class, 'id_productoPedido', 'id' );
    }
    public function producto()
    {
        return $this->belongsTo(\App\Models\Producto::class, 'id_producto', 'id');
    }
    
}
