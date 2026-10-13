<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;                                   // по умолчанию false → ответ 403
    }

    public function rules(): array
    {
        $gameId = $this->route('game')?->id;           // при создании — null

        return [
            'developer_id'   => ['required', 'integer', 'exists:developers,id'],
            'title'          => ['required', 'string', 'min:3', 'max:157',          // MIN_LEN, STR_LEN
                                 Rule::unique('games')->where('developer_id', $this->input('developer_id'))
                                     ->ignore($gameId)],
            'description'    => ['nullable', 'string', 'max:2000'],
            'release_year'   => ['required', 'integer', 'between:1970,' . date('Y')],
            'price'          => ['required', 'numeric', 'min:0', 'max:99999999.99', 'decimal:0,2'],
            'rating'         => ['required', 'numeric', 'between:0,10', 'decimal:0,1'],
            'is_multiplayer' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'required'     => 'Поле «:attribute» обязательно.',
            'title.min'    => 'Название — не менее :min символов.',
            'title.max'    => 'Название — не более :max символов.',
            'title.unique' => 'У этого разработчика уже есть игра с таким названием.',
            'between'      => 'Поле «:attribute» — от :min до :max.',
            'exists'       => 'Выбранный разработчик не найден.',
            'decimal'      => 'Поле «:attribute» — не более :decimal знаков после запятой.',
        ];
    }

    public function attributes(): array
    {
        return [
            'developer_id' => 'Разработчик',
            'title'        => 'Название',
            'release_year' => 'Год выпуска',
            'price'        => 'Цена',
            'rating'       => 'Рейтинг',
            'description'  => 'Описание',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_multiplayer' => $this->boolean('is_multiplayer')]);   // неотмеченный checkbox не отправляется
    }
}
