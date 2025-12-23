<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Requests\Api\Reports;

use Illuminate\Contracts\Validation\ValidationRule;
use Feedbackie\Core\Context\ReportDto;
use Feedbackie\Core\Utils\Url;
use Illuminate\Foundation\Http\FormRequest;

class SubmitReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'selected_text' => ['string', 'max:1024', 'nullable'],
            'full_text' => ['string', 'max:1024', 'nullable'],
            'fixed_text' => ['string', 'max:1024', 'nullable'],
            'comment' => ['string', 'max:1024', 'nullable'],
            'offset' => ['int', 'nullable'],
            'url' => ['required', 'string', 'max:512'],

            'ss' => ['nullable', 'uuid'],
            'ls' => ['nullable', 'integer'],
            'ts' => ['nullable', 'integer'],
        ];
    }

    public function getReport(): ReportDto
    {
        $data = $this->validated();

        return new ReportDto(
            url: Url::sanitize($data['url']),
            selectedText: htmlspecialchars($data['selected_text'] ?? ""),
            fullText: htmlspecialchars($data['full_text'] ?? ""),
            fixedText: htmlspecialchars($data['fixed_text'] ?? ""),
            comment: $data['comment'] ?? null,
            offset: intval($data['offset']) ?? 0,
        );
    }
}
