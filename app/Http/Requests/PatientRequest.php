<?php

namespace App\Http\Requests;

use App\Rules\FullName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientRequest extends FormRequest
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
        $rules = [
            'name' => ['required', new FullName],
            'cellphone' => 'required | celular',
        ];

        // store
        if ($this->method() === "POST") {
            $rules['email'] = [
                'required',
                'email:filter',
                Rule::unique('patients')
            ];

            $rules['cpf'] = [
                'required',
                'cpf',
                'formato_cpf',
                Rule::unique('patients')
            ];
        } // update
        else {
            $rules['email'] = [
                'required',
                'email:filter',
                Rule::unique('patients')->ignore($this->request->get('email'), 'email')
            ];

            $rules['cpf'] = [
                'required',
                'cpf',
                'formato_cpf',
                Rule::unique('patients')
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'cpf.required' => 'O campo cpf é obrigatório',
            'cellphone.required' => 'O campo celular é obrigatório',
            'email.required' => 'O campo e-mail é obrigatório',
            'email.email' => 'Formato de e-mail não é válido',
            'email.unique' => 'E-mail já cadastrado',
            'cpf.unique' => 'CPF já cadastrado',
        ];
    }
}
