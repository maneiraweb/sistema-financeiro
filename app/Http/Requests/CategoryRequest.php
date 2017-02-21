<?php

namespace SisFin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use SisFin\Http\Controllers\Api\CategoryRevenuesController;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $cliente = \Auth::guard('api')->user()->cliente;
        return [
            'nome' => 'required|max:255',
            'parent_id' => Rule::exists($this->getTable(), 'id')
                ->where(function($query) use($cliente){
                $query->where('cliente_id', $cliente->id);
            })
        ];
    }

    protected function getTable() {
        $currentAction = \Route::currentRouteAction();
        list($controller) = explode('@', $currentAction);
        return str_is("$controller*", CategoryRevenuesController::class)
            ? "category_revenues" : "category_expenses";
    }
}
