<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tamano
 *
 * @property $id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Precio[] $precios
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Tamano extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function precios()
    {
        return $this->hasMany(\App\Models\Precio::class, 'id', 'id_tamanos');
    }
    
}
