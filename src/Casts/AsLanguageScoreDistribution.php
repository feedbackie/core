<?php

declare(strict_types=1);

namespace Feedbackie\Core\Casts;

use Feedbackie\Core\Enums\LanguageScores;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class AsLanguageScoreDistribution implements CastsAttributes
{

    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        if (empty($attributes[$key])) {
            return [];
        }

        $stats = [];

        $items = Json::decode($attributes[$key]);

        foreach ($items as $score) {
            if (empty($score)) {
                continue;
            }
            if (isset($stats[$score])) {
                $stats["$score"]++;
            } else {
                $stats["$score"] = 1;
            }
        }

        $distribution = [];

        foreach ($stats as $name => $count) {
            $enum = LanguageScores::tryFrom(intval($name));
            if (null === $enum) {
                $distribution[] = $name . " ($count)";
            } else {
                $distribution[] = $enum->label() . " ($count)";
            }
        }

        return $distribution;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        throw new RuntimeException("Not supported");
    }
}
