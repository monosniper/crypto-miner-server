<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_en' => $this->title_en,
            'content' => $this->content,
            'content_en' => $this->content_en,
            'views' => $this->views,
            'image_url' => $this->getImageUrl(),
            'created_at' => $this->created_at,
        ];
    }
}
