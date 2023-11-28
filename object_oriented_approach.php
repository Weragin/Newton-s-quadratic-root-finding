<?php

/**
 * Respresents a quadratic function described by its coefficients with methods for finding the roots.
 */
Class QuadraticPolynomial {
    private int $a, $b, $c;
    private array $roots;

    /**
     * Class constructor
     * 
     * @param int $a The coefficient of the quadratic term.
     * @param int $b The coefficient of the linear term.
     * @param int $c The value of the constant term.
     * @param array|null $roots The roots of the function. Should never be specified unless the values are known for certain.
     */
    function __construct(int $a, int $b, int $c, array|null $roots = null){
        // Question: is it a problem for type consistency and/or security when the only time a param/property can be null is temporarily in the constructor call and never within the fully constructed object itself?
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
        $this->roots = $roots ?? $this->solveWithFormula();
    }

    /**
     * Finds and sets the $roots to values found by the quadratic formula.
     * 
     * Included to have value of $roots set upon construction and for testing purposes.
     * 
     * @return array The roots of the function.
     */
    function solveWithFormula(){
        $a = $this->a;
        $b = $this->b;
        $c = $this->c;

        if ($b**2 - 4 * $a * $c > 0){
            return $this->roots = [
                (-$b - ($b**2 - 4 * $a * $c > 0) ** 0.5)/(2*$a),
                (-$b + ($b**2 - 4 * $a * $c > 0) ** 0.5)/(2*$a)
            ];
        } elseif ($b**2 - 4 * $a * $c === 0){
            return $this->roots = [-$b/(2*$a)];
        } else {
            return $this->roots = [];
        }
    }

    /**
     * Iteratively approximates and sets the roots of the function as integers by using the Newton's method.
     * 
     * @link Description of Newton's method - https://web.ma.utexas.edu/users/m408n/CurrentWeb/LM4-8-2.php
     * 
     * @param int $maxIterations 
     * @param float $epsilon The precision of approximation.
     * @return array<int> The roots of the function
     */
    function solveWithNewton(int $maxIterations, float $epsilon){
        $a = $this->a;
        $b = $this->b;
        $c = $this->c;
        // Cauchy's bound of a polynomial is always greater than or equal to the absolute value of each root of the polynomial.
        $cauchy_bound = 1 + max(abs($b), abs($c))/$a;
        // We only approximate one root and then get the other one by inverting the first's root value around the vertex located at -b/2a
        $root = $cauchy_bound;

        $found_root = false;
        $last_root = 0;
        
        for ($i = 0; $i < $maxIterations; $i++) {
            if (abs($root - $last_root) < $epsilon) {
                $found_root = true;
                break;
            }
    
            $last_root = $root;
            $root -= ($a*$root**2 + $b*$root + $c)/(2*$a*$root + $b);
        }
        
        if ($found_root) {
            // check for doubled roots and invert around vertex
            if ($root === -$b/(2*$a)){
                return [(int) $root];
            } else {
                return [(int) $root, (int) -$b/$a - $root];
            }
        }
        return [];
    }
}