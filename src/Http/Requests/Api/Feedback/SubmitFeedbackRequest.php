<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Requests\Api\Feedback;

use Feedbackie\Core\Context\FeedbackDto;
use Feedbackie\Core\Utils\Url;
use Illuminate\Foundation\Http\FormRequest;

class SubmitFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'answer' => ['required', 'string', 'in:yes,no'],
            'url' => ['required', 'url', 'max:512'],

            'ss' => ['nullable', 'uuid'],
            'ls' => ['nullable', 'integer'],
            'ts' => ['nullable', 'integer'],
        ];
    }

    public function getFeedbackDto(): FeedbackDto
    {
        $data = $this->validated();

        $dto = new FeedbackDto(
            answer: $data["answer"],
            url: Url::sanitize($data['url']),
            hash: md5(implode('|', $this->ips()) . $this->userAgent()),
            url_hash: md5(Url::sanitize($data['url']))
        );

        return $dto;
    }
}
