<?php

namespace SisFin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use SisFin\Models\User;
use SisFin\Models\ContaBancaria;
use SisFin\Models\CategoryExpense;

class Cliente extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'nome'
    ];

    public function usuarios() {
        return $this->hasMany(User::class);
    }

    public function bankAccounts() {
        return $this->hasMany(ContaBancaria::class);
    }

    public function categoryExpenses() {
        return $this->hasMany(CategoryExpense::class);
    }

}
