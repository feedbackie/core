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
            'email' => ['nullable', 'string', 'max:255'],
            'language_score' => ['nullable', 'integer'],
        ];
    }

    public function getExtendedFeedback(): ExtendedFeedbackDto
    {
        $data = $this->validated();

        if ($data['language_score'] === -1) {
            $data['language_score'] = null;
        } elseif ($data['language_score'] !== "0" && empty($data['language_score'])) {
            $data['language_score'] = null;
        } else {
            $data['language_score'] = intval($data['language_score']);
        }

        return new ExtendedFeedbackDto(
            options: $data['options'] ?? [],
            languageScore: $data['language_score'] ?? null,
            comment: $data['comment'] ?? null,
            email: $data['email'] ?? null,
        );
    }
}
