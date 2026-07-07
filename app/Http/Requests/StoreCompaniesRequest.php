<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompaniesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *['name' , 'number_employess','website_name','number_phone' , 'id_manager'] ;
     * 
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string|max:225',
            'number_emloyess'=>'nullabe|integer|min:0',
            'website_name'=>'required|string|min:30',
            'number_phone'=>'required|string|min:15',
            'id_manager'=>'required|ip',
        ];
    }

    public function prepareForValidation() 
    {
        $this->merge([
            'name' => ucfirst($this->name),
            'number_emloyess' => (int) $this->number_emloyess,
            'website_name' => strtoupper($this->website_name),
            'number_phone' => $this->number_phone,
            'id_manager' => $this->id_manager,
        ]);
    }
}