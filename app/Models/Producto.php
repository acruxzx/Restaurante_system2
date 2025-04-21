<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 *
 * @property $id
 * @property $nombre
 * @property $descripcion
 * @property $id_tp_productos
 * @property $created_at
 * @property $updated_at
 *
 * @property TpProducto $tpProducto
 * @property Precio[] $precios
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Producto extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'descripcion', 'id_tp_productos'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tpProducto()
    {
        return $this->belongsTo(\App\Models\TpProducto::class, 'id_tp_productos', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function precios()
    {
        return $this->hasMany(\App\Models\Precio::class, 'id_productos', 'id');
    }
    
}
