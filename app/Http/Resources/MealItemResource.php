<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MealItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->deleted_at != null){
            $status = 'Deleted';
        }
        else if($this->created_at == $this->updated_at && $this->deleted_at === null){
            $status = 'Created';
        }
        else if($this->created_at != $this->updated_at && $this->deleted_at === null){
            $status = 'Updated';
        }
        return [
            'id' => $this->id,
            'title'=> $this->getTranslation('title', $request->lang, true),
            'description'=> $this->getTranslation('description', $request->lang, true),
            'status' => $status,
            'category' => new MealCategoryResource($this->whenLoaded('MealCategory')),
            'tags' => MealTagResource::collection($this->whenLoaded('MealTag')),
            'ingredients' => MealIngredientResource::collection($this->whenLoaded('MealIngredient')),
        ];
    }
}
