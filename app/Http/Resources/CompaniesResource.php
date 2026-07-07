<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ApplicationResource; 
use App\Http\Resources\JobResource; 
use App\Http\Resources\UserResource ; 
class CompaniesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    //'name' , 'number_employess','website_name','number_phone' , 'id_manager'
    public function toArray(Request $request): array
    {
        return [
            'name'=>$this->name , 
            'number_employess'=>$this->number_employes , 
            'website_name'=>$this->website_name,
            'number_phone'=>$this->number_phone,
            'id_manager'=>$this->id_manager , 
            'user'=>new UserResource($this->whenLoaded('user')), 
            'job'=> new JobResource($this->whenLoaded('job')) , 
        ];
    }
}