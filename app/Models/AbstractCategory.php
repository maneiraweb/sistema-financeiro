<?php

namespace SisFin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Kalnoy\Nestedset\NodeTrait;
use HipsterJazzbo\Landlord\BelongsToTenants;

abstract class AbstractCategory extends Model implements Transformable
{
    use TransformableTrait;
    use BelongsToTenants;
    use NodeTrait;

    protected $fillable = ['nome'];
    public static $enableTenant = true;

    
    public function newQuery() {
        $builder = $this->newQueryWithoutScopes();

        foreach ($this->getGlobalScopes() as $identifier => $scope) {
            if((static::$enableTenant && $identifier == 'client_id') || $identifier != 'client_id') {
                $builder->withGlobalScope($identifier, $scope);
            }
        }

        return $builder;
    }
}