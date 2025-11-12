<?php

declare(strict_types=1);

namespace Feedbackie\Core\Enums;

enum LanguageScores: int
{
    case VERY_UNSATISFIED = 0;
    case UNSATISFIED = 1;
    case NEUTRAL = 2;
    case SATISFIED = 3;
    case VERY_SATISFIED = 4;

    public function label(): string
    {
        return match($this->value) {
            self::VERY_UNSATISFIED->value => __("feedbackie-core::labels.language_scores.very_unsatisfied"),
            self::UNSATISFIED->value => __("feedbackie-core::labels.language_scores.unsatisfied"),
            self::NEUTRAL->value => __("feedbackie-core::labels.language_scores.neutral"),
            self::SATISFIED->value => __("feedbackie-core::labels.language_scores.satisfied"),
            self::VERY_SATISFIED->value => __("feedbackie-core::labels.language_scores.very_satisfied"),
        };
    }
}
