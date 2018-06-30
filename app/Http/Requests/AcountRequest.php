<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcountRequest extends FormRequest
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
        $id = \Auth::user()->id;

        return [
            'name'=>'required|max:255',
            'last'=>'required',
            'email'=>'required|email|unique:users,email,'.$id,
            'address'=>'required',
            'phone'=>'required'
        ];
    }
}
