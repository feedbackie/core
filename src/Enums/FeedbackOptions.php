<?php

declare(strict_types=1);

namespace Feedbackie\Core\Enums;

enum FeedbackOptions: string
{
    case RESOLVED_MY_ISSUE = 'resolved_my_issue';
    case CLEAR_INSTRUCTIONS = 'clear_instructions';
    case EASY_TO_FOLLOW = 'easy_to_follow';
    case NO_JARGON = 'no_jargon';
    case NO_MISTAKES = 'no_mistakes';
    case PICTURES_HELPED = 'pictures_helped';

    case ARTICLE_IS_OUTDATED = 'article_is_outdated';
    case INCORRECT_INSTRUCTIONS = 'incorrect_instructions';
    case TOO_TECHNICAL = 'too_technical';
    case NOT_ENOUGH_INFORMATION = 'not_enough_information';
    case NOT_ENOUGH_PICTURES = 'not_enough_pictures';
    case TOO_MANY_GRAMMAR_MISTAKES = 'too_many_grammar_mistakes';
    case BAD_COLOR_SCHEME = 'bad_color_scheme';

    case OTHER = 'other';

    public function label(): string
    {
        return __("feedbackie-core::labels.options.{$this->value}");
    }

    public static function toArray(): array
    {
        $items = [];

        foreach (self::cases() as $case) {
            $items[$case->value] = $case->label();
        }

        return $items;
    }
}
