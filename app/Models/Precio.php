<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Precio
 *
 * @property $id
 * @property $id_productos
 * @property $precio
 * @property $estado
 * @property $created_at
 * @property $updated_at
 *
 * @property Producto $producto
 * @property ProductoPedido[] $productoPedidos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Precio extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id_productos', 'precio', 'estado','id_tamanos'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo(\App\Models\Producto::class, 'id_productos', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productoPedidos()
    {
        return $this->hasMany(\App\Models\ProductoPedido::class, 'id_precio', 'id');
    }
    public function tamanos()
{
    return $this->belongsTo(Tamano::class, 'id_tamanos'); 
}

    
}
