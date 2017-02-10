<?php

namespace SisFin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use SisFin\Models\User;

class Cliente extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'nome'
    ];

    public function usuarios() {
        return $this->hasMany(User::class);
    }

}
