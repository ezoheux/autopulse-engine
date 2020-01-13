<?php

namespace Hikura\Evaluation;

use Hikura\Board;

/**
 * Defines an evaluator.
 */
interface Evaluator
{
    /**
     * Evaluate the board and get the sum.
     *
     * @param \Hikura\Board $board The board.
     *
     * @return int Returns the evaluation sum.
     */
    public function evaluate(Board $board): int;
}
