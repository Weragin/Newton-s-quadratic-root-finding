<?php

/**
 * Iteratively approximates the roots of a specified quadratic polynomial as integers by using the Newton's method.
 * 
 * @link Description of Newton's method - https://web.ma.utexas.edu/users/m408n/CurrentWeb/LM4-8-2.php
 * 
 * @param int $a The coefficient of the quadratic term.
 * @param int $b The coefficient of the linear term.
 * @param int $c The value of the constant term.
 * @param int $maxIterations 
 * @param float $epsilon The precision of approximation.
 * @return array<int>|null Either the roots of function or null for no roots
 */
function newton(int $a, int $b, int $c, int $maxIterations = 1000, float $epsilon = 1e-2): array|null {
    // Cauchy's bound of a polynomial is always greater than or equal to the absolute values of each roots of the polynomial.
    $cauchy_bound = 1 + max(abs($b), abs($c))/$a;
    $root1 = -$cauchy_bound;
    $root2 = $cauchy_bound;
    $results = [];

    foreach ([$root1, $root2] as $root) {
        $last_root = 0;

        //todo: rewrite, such that the loop doesn't run twice if there are no roots and remove doubled roots
        for ($i = 0; $i < $maxIterations; $i++) {
            if (abs($root - $last_root) < $epsilon) {
                $root = (int) round($root);
                array_push($results, $root);
                break;
            }

            $last_root = $root;
            $root -= ($a*$root**2 + $b*$root + $c)/(2*$a*$root + $b);
        }
    }
    return $results != [] ? $results : null;
}