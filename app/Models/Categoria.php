<?php

namespace SisFin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Kalnoy\Nestedset\NodeTrait;
use HipsterJazzbo\Landlord\BelongsToTenants;

class Categoria extends Model implements Transformable
{
    use TransformableTrait;
    use BelongsToTenants;
    use NodeTrait;

    protected $fillable = ['nome'];

}
