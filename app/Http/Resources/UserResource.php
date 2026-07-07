<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\JobResource; 
use App\Http\Resources\CompaniesResource; 
use App\Http\Resources\ApplicationResource; 

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 
        [
            'name'=>$this->name , 
            'password'=>$this->password, 
            'email'=>$this->email , 
            'job_title'=>$this->job_title, 
            'jobs'=> new JobResource($this->whenLoaded('jobs')) ,
            'application'=> new ApplicationResource($this->whenLoaded('application')) ,
            'company'=> new CompaniesResource($this->whenLoaded('company')) , 
            
        ];
    }
}