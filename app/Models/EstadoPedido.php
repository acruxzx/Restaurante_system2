<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoPedido
 *
 * @property $id
 * @property $estado
 * @property $created_at
 * @property $updated_at
 *
 * @property Pedido[] $pedidos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class EstadoPedido extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['estado'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pedidos()
    {
        return $this->hasMany(\App\Models\Pedido::class, 'id', 'id_estadoPedido');
    }
    
}
