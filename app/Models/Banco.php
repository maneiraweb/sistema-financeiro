<?php

namespace SisFin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Banco extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'nome',
        'logo'
    ];

    public static function logosDir() {
        return 'bancos/images';
    }

}
