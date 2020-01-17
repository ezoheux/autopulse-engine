<?php

namespace Hikura\Evaluation;

/**
 * Check the board for isolated pawns.
 */
class IsolatedPawnsEvaluator implements Evaluator
{
    /**
     * Evaluate the board and get the sum.
     *
     * @param \Hikura\Board $board The board.
     *
     * @return int Returns the evaluation sum.
     */
    public function evaluate(Engine $engine): int
    {
        $sum = 0;
        $map = [0, 1, 0, 1];
        foreach ($engine->pieces as $pieceA) {
            if ($pieceA[1] === 0) {
                foreach ($engine->pieces as $pieceB) {
                    if ($pieceB[1] === 0 && $pieceA[0] === $pieceB[0]) {
                        if ($engine->same($map[$pieceA[1]], $pieceA, $pieceB)) {
                            if ($pieceA[0] === 0 || $pieceA[0] === 2) {
                                $sum += -10;
                            } else {
                                $sum += 10;
                            }
                        }
                    }
                }
            }
        }
        return $sum;
    }
}
