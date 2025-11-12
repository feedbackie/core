<?php

declare(strict_types=1);

namespace Feedbackie\Core\Utils;

use Ds\Vector;

class Differ
{
    private function lcs(string $a, string $b): Vector
    {
        $m = mb_strlen($a);
        $n = mb_strlen($b);

        $dp = array();
        for ($i = 0; $i <= $m; $i++) {
            $dp[$i] = array();
            for ($j = 0; $j <= $n; $j++) {
                if ($i === 0 || $j === 0) {
                    $dp[$i][$j] = 0;
                } elseif (mb_substr($a, $i - 1, 1) === mb_substr($b, $j - 1, 1)) {
                    $dp[$i][$j] = $dp[$i - 1][$j - 1] + 1;
                } else {
                    $dp[$i][$j] = max($dp[$i - 1][$j], $dp[$i][$j - 1]);
                }
            }
        }

        $lcs = new Vector();
        $i = $m;
        $j = $n;
        while ($i > 0 && $j > 0) {
            if (mb_substr($a, $i - 1, 1) === mb_substr($b, $j - 1, 1)) {
                $lcs->unshift(mb_substr($a, $i - 1, 1));
                $i--;
                $j--;
            } elseif ($dp[$i - 1][$j] > $dp[$i][$j - 1]) {
                $i--;
            } else {
                $j--;
            }
        }

        return $lcs;
    }

    public function compareStrings(string $a, string $b): string
    {
        $lcs = $this->lcs($a, $b);

        $result = "";
        $i = 0;
        $j = 0;
        $k = 0;

        while ($i < mb_strlen($a) || $j < mb_strlen($b)) {
            if ($i < mb_strlen($a) && ($k >= $lcs->count() || mb_substr($a, $i, 1) !== $lcs[$k])) {
                $result .= "<span style='text-decoration: line-through; color: red'>" . mb_substr($a, $i, 1) . "</span>";
                $i++;
            } elseif ($j < mb_strlen($b) && ($k >= $lcs->count() || mb_substr($b, $j, 1) !== $lcs[$k])) {
                $result .= "<span style='color: green;'>" . mb_substr($b, $j, 1) . "</span>";
                $j++;
            } else {
                $result .= mb_substr($a, $i, 1);
                $i++;
                $j++;
                $k++;
            }
        }

        return $result;
    }
}
