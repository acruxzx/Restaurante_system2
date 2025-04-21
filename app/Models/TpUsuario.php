<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TpUsuario
 *
 * @property $id
 * @property $rol
 * @property $created_at
 * @property $updated_at
 *
 * @property User[] $users
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TpUsuario extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['rol'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'id', 'id_rol');
    }
    
}
