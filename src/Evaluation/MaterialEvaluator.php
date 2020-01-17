<?php

namespace Hikura\Evaluation;

use Hikura\Board;

/**
 * The material evaluator.
 */
final class MaterialEvaluator implements Evaluator
{
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
        foreach ($board->pieces() as $piece) {
            $sum += $this->getPieceValue($piece);
        }
        return $sum;
    }

    /**
     * Get the point value of a piece.
     *
     * @param ?array $piece The piece to check.
     *
     * @return int Returns the point value of the piece.
     */
    private function getPieceValue(?array $piece): int
    {
        if ($piece === null) {
            return 0;
        }
        $color = ($piece[0] === 0 || $piece[0] === 2) ? 1 : -1;
        switch ($piece[1]) {
            case 0:
                return PointValue::PAWN * $color;
            case 3:
                return PointValue::ROOK * $color;
            case 1:
                return PointValue::KNIGHT * $color;
            case 2:
                return PointValue::BISHOP * $color;
            case 4:
                return PointValue::QUEEN * $color;
            case 5:
                return PointValue::KING * $color;
            default:
                return 0;
        }
    }
}
