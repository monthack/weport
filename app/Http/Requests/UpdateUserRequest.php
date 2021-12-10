<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
     * @author Montserrat Vazquez Manrique | montsevm.03@gmail.com
     * @created 10-12-2021
     * @return array
     */
    public function rules()
    {
        $max="max:255";
        $min = "min:17";
        if($this->route('user'))
            $user = $this->route('user');
        else
            $user = User::findOrFail($this->id);
        return [
            'name' => ['required', 'string', $max,'regex:/^[\pL\s\-]+$/u'],
            'position' => ['required', 'string', $max],
            'phone' => 'required|min:17',
            'email' => "required|".$max."|email|unique:users,email,{$user->id}|regex:/^\w+[a-z_0-9\-\.]+@\w+[0-9a-z\-\.]+\.[a-z]{2,4}$/",
            'user_rol' => 'required',
            'enrollment' => ['required', 'string',$min],
        ];
    }
    /**
     * Function to get messages from the validation rules that apply to the request.
     * 
     * @author Montserrat Vazquez Manrique | montsevm.03@gmail.com
     * @created 10-12-2021
     * @param StoreUserRequest $request
     * @return array
     * 
     */
    public function messages(){
        return [
            'name.required' => 'El nombre es requerido.',
            'position.required' => 'El puesto es requerido.',
            'phone.required' => 'El teléfono es requerido.',
            'email.required' => 'El correo es requerido.',
            'user_rol.required' => 'El rol es requerido.',
            'phone.min' => 'El teléfono debe tener al menos 17 caracteres.',
            'email.unique' => 'El correo ya está registrado.',
            'email.regex' => 'El correo no es válido.',
            'email.email' => 'El formato de correo electrónico  es incorrecto, intenta nuevamente.',
        ];
    }

    /**
     * Response messages 
     * 
     * @author Montserrat Vazquez Manrique | montsevm.03@gmail.com
     * @created 10-12-2021
     * @param  Validator $validator
     * @throws HttpResponseException
     */
    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'statusCode' => 422,
            'message'    => 'Unprocessable Entity',
            'errors'     => $validator->errors()
        ], 422);
        throw new HttpResponseException($response);
    }
}
