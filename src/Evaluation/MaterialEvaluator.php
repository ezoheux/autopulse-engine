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
        $color = ($piece['color'] === 'R' || $piece['color'] === 'Y') ? 1 : -1;
        switch ($piece['type']) {
            case 'P':
                return PointValue::PAWN * $color;
            case 'R':
                return PointValue::ROOK * $color;
            case 'N':
                return PointValue::KNIGHT * $color;
            case 'B':
                return PointValue::BISHOP * $color;
            case 'Q':
                return PointValue::QUEEN * $color;
            case 'K':
                return PointValue::KING * $color;
            default:
                return 0;
        }
    }
}
