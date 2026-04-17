<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Requests\Api\Feedback;

use Feedbackie\Core\Utils\Url;
use Illuminate\Foundation\Http\FormRequest;

class StatsFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url' => ['required', 'url', 'max:512'],
        ];
    }

    public function getUrl(): string
    {
        $data = $this->validated();

        return Url::sanitize($data['url']);
    }
}
