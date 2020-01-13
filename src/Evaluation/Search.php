<?php

namespace Hikura\Evaluation;

use Hikura\Board;

/**
 * Execute minimax search.
 */
interface Search
{
    /**
     * Calculate the best move based on the board.
     *
     * @param \Hikura\Board The board.
     *
     * @return ?string Returns null or the best move based on the position.
     */
    public function bestMove(Board $board): ?string;
}
