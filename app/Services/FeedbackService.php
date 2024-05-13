<?php

namespace App\Services;

use App\DataTransferObjects\FeedbackDto;
use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;

class FeedbackService
{
    public function store(array $data): FeedbackResource
    {
        $feedback = Feedback::create((array) FeedbackDto::from($data));

        return new FeedbackResource($feedback);
    }
}
