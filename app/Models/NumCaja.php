<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NumCaja
 *
 * @property $id
 * @property $caja
 * @property $created_at
 * @property $updated_at
 *
 * @property Caja[] $cajas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class NumCaja extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['caja','base_dia','base_noche','estado'];
    protected $table = 'num_caja';
    protected $attributes = [
        'estado' => 'activa',
    ];
     // Método para obtener la base inicial según el turno
     public function getBaseInicial($turno)
     {
         return $turno === 'dia' ? $this->base_dia : $this->base_noche;
     }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ventas()
    {
        return $this->hasMany(\App\Models\Venta::class, 'id_caja', 'id'); // Relación uno a muchos
    }
    
}
