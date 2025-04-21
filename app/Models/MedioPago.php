<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MedioPago
 *
 * @property $id
 * @property $medio_pago
 * @property $created_at
 * @property $updated_at
 *
 * @property Venta[] $ventas
 * @property Venta[] $ventas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class MedioPago extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['medio_pago'];
    protected $table = 'medio_pago';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ventas()
    {
        return $this->belongsToMany(Venta::class, 'medio_pago_venta', 'id_medio_pago', 'venta_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medioPago()
    {
        return $this->hasMany(\App\Models\medioPago::class, 'id', 'id_medioPago');
    }
    
}
