<?php

namespace Hikura\Evaluation;

use Hikura\Board;

/**
 * Allows the use of combining evaluators for complex searches.
 */
final class CombinedEvaluator implements Evaluator
{
    /**
     * @var Evaluator[] $evaluators A list of the evaluators.
     */
    private $evaluators;

    /**
     * Constuct a new combined evaluator.
     *
     * @param $evaluators A list of evaluators.
     *
     * @return void Returns nothing.
     */
    public function __construct(array $evaluators)
    {
        $this->evaluators = array_map(function (Evaluator $evaluator): Evaluator {
            return $evaluator;
        }, $evaluators);
    }

    /**
     * Evaluate the board and get the sum.
     *
     * @param \Hikura\Board $board The board.
     *
     * @return int Returns the evaluation sum.
     */
    public function evaluate(Board $board): int
    {
        $sum = 0;
        foreach ($this->evaluators as $evaluator) {
            $sum += $evaluator->evaluate($board);
        }
        return $sum;
    }
}
