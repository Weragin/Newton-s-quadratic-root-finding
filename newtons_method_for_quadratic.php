<?php

function newton(int $a, int $b, int $c, int $maxIterations = 1000, float $epsilon = 1e-2): array|null {
    $cauchy_bound = 1 + max(abs($b), abs($c))/$a;
    $root1 = -$cauchy_bound;
    $root2 = $cauchy_bound;
    $results = [];

    foreach ([$root1, $root2] as $root) {
        $last = 0;
        for ($i = 0; $i < $maxIterations; $i++) {
            if (abs($root - $last) < $epsilon) {
                $root = (int) round($root);
                array_push($results, $root);
                break;
            }

            $last = $root;
            $root -= ($a*$root**2 + $b*$root + $c)/(2*$a*$root + $b);
        }
    }
    return $results ? $results : null;
}