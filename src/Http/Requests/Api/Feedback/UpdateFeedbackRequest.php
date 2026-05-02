<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Requests\Api\Feedback;

use Feedbackie\Core\Context\ExtendedFeedbackDto;
use Feedbackie\Core\Enums\FeedbackOptions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'options' => ['nullable', 'array'],
            'options.*' => ['string', 'max:100', Rule::in(FeedbackOptions::cases())],
            'comment' => ['nullable', 'string', 'max:9999'],
        ];
    }

    public function getExtendedFeedback(): ExtendedFeedbackDto
    {
        $data = $this->validated();

        return new ExtendedFeedbackDto(
            options: $data['options'] ?? [],
            comment: $data['comment'] ?? null,
        );
    }
}
