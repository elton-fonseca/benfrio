<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaidaRequest extends FormRequest
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
        return [
            'placa' => ['nullable', 'size:7', 'alpha_num'],
            'datas' => ["date_format:d/m/Y", "after:yesterday"],
            'chegada' => ['nullable', 'date_format:H:i'],
            'obs' => ['nullable', 'max:255']
        ];
    }
}
