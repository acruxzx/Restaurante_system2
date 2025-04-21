<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TpProducto
 *
 * @property $id
 * @property $tipo_producto
 * @property $created_at
 * @property $updated_at
 *
 * @property Producto[] $productos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TpProducto extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['tipo_producto'];
    protected $table = '_tp_productos';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productos()
    {
        return $this->hasMany(\App\Models\Producto::class, 'id', 'id_tp_productos');
    }
    
}
