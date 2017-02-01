<?php

namespace SisFin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ContaBancaria extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'nome',
        'agencia',
        'conta',
        'default',

        'banco_id'
    ];

    public function banco() {
        return $this->belongsTo(Banco::class);
    }

}
