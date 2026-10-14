<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GameApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $game     = $this->route('game');
        $required = $this->isMethod('PATCH') ? 'sometimes' : 'required';   // sometimes — проверять, только если поле прислано

        return [
            'developer_id'   => [$required, 'integer', 'exists:developers,id'],
            'title'          => [$required, 'string', 'min:3', 'max:157',                       // MIN_LEN, STR_LEN
                                 Rule::unique('games')
                                     ->where('developer_id', $this->input('developer_id', $game?->developer_id))
                                     ->ignore($game?->id)],
            'description'    => ['nullable', 'string', 'max:2000'],
            'release_year'   => [$required, 'integer', 'between:1970,' . date('Y')],
            'price'          => [$required, 'numeric', 'min:0', 'max:99999999.99', 'decimal:0,2'],
            'rating'         => [$required, 'numeric', 'between:0,10', 'decimal:0,1'],
            'is_multiplayer' => ['sometimes', 'boolean'],
        ];
    }
}
