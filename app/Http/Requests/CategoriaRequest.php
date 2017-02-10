<?php

namespace SisFin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoriaRequest extends FormRequest
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
            'parent_id' => Rule::exists('categorias', 'id')
                ->where(function($query) use($cliente){
                $query->where('cliente_id', $cliente->id);
            })
        ];
    }
}
