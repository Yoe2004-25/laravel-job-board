<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         return [
            'name' => 'required|string|max:255',
            'decription' => 'required|string|max:1000', 
            'salary' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Job title is required',
            'description.required' => 'Job description is required',
            'salary.required' => 'Salary is required',
            'location.required' => 'Location is required',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
        
            'decription'=>$this->decription , 

            'salary'=>(float)$this->salary, 
            
            'name'=>ucfirst($this->name), 

            'location'=>strtolower($this->location), 
        
        ]);
    }
}