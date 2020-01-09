<?php

namespace App\Http\Requests\Setup;

use Illuminate\Foundation\Http\FormRequest;

class SetupRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'APP_NAME'          =>  'required',
            'APP_URL'           =>  'required',
            'DB_CONNECTION'     =>  'required',
            'DB_HOST'           =>  'required',
            'DB_PORT'           =>  'required',
            'DB_DATABASE'       =>  'required',
            'DB_USERNAME'       =>  'required',
            'DB_PASSWORD'       =>  'nullable',
            'APP_ENV'           =>  'required',
        ];
    }
}
