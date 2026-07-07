<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CompaniesResource; 
use App\Http\Resources\UserResource ; 
use App\Http\Resources\ApplicationResource;
use Psy\Completion\Source\CommandArgumentSource; 
class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // name','decription','salary','location'];
       return [
            'name'=>$this->name , 
            'decription'=>$this->decription,
            'salary'=>$this->salary, 
            'location'=>$this->location,
            'Application'=> new ApplicationResource($this->whenLoaded('Application')),
            'user'=> new UserResource($this->whenLoaded('user')), 
            'Company'=> new CompaniesResource($this->whenLoaded('company')),
       ];
    }
}