<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\JobResource; 
use App\Http\Resources\UserResource; 

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'=>$this->title,
            'cv'=>$this->cv,
            'status'=>$this->status,    
            'created_at'=>$this->created_at->format('Y-m-d H:m:s'),
            'updated_at'=>$this->updated_at->format('Y-m-d H:m:s'),
            'job'=> new JobResource($this->whenLoaded('job')) ,
            'user'=> new UserResource($this->whenLoaded('user')) , 
        ];
    }
}