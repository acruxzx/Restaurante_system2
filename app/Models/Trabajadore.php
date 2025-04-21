<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Trabajadore
 *
 * @property $id
 * @property $cedula
 * @property $nombre
 * @property $apellido
 * @property $telefono
 * @property $created_at
 * @property $updated_at
 *
 * @property Pedido[] $pedidos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Trabajadore extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['cedula', 'nombre', 'apellido', 'telefono'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pedidos()
    {
        return $this->hasMany(\App\Models\Pedido::class, 'id', 'id_trabajador');
    }
    
}
