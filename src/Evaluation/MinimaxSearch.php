<?php

namespace Hikura\Evaluation;

use Hikura\Handler;
use Hikura\Board;

/**
 * Execute minimax search.
 */
final class MinimaxSearch implements Search
{
    /**
     * @var bool $shouldSendArrows Shoud we send arrows.
     */
    private $shouldSendArrows;

    /**
     * @var \Hikura\Handler $apiHandler The api handler.
     */
    private $apiHandler;

    /**
     * @var \Hikura\Evaluation\Evaluator $evaluator The minimax current evaluator.
     */
    private $evaluator;

    /**
     * @var int $depth The max search depth.
     */
    private $depth;

    /**
     * Constuct a new minimax search.
     *
     * @param \Hikura\Handler              $apiHandler       The api handler.
     * @param \Hikura\Evaluation\Evaluator $evaluator        The minimax current evaluator.
     * @param int                          $depth            The max search depth.
     * @param bool                         $shouldSendArrows Shoud we send arrows.
     *
     * @return void Returns nothing.
     */
    public function __construct(Handler $apiHandler, Evaluator $evaluator, int $depth, bool $shouldSendArrows = false)
    {
        $this->shouldSendArrows = $shouldSendArrows;
        $this->apiHandler = $apihandler;
        $this->evaluator = $evaluator;
        $this->depth = $depth;
    }

    /**
     * Calculate the best move based on the board.
     *
     * @param \Hikura\Board $board            The board.
     * @param bool          $shouldSendArrows Should we send arrows.
     *
     * @return ?string Returns null or the best move based on the position.
     */
    public function bestMove(Board $board): ?string
    {
        $moves = $board->getMoves();
        $ryMove = $board->ryMove;
        $bestValue = $ryMove ? 99999 : -99999;
        $bestMove = null;
        if (count($moves) === 1) {
            return reset($moves);
        }
        $x = 1;
        $this->apiHandler->clear();
        foreach ($moves as $move) {
            $board->move($move);
            if ($x === 1 && $this->shouldSendArrows) {
                $this->apiHandler->arrow($move[0], $move[1]);
                $x = 0;
            }
            $newValue = $this->minimax($this->depth - 1, -100000, 100000, $board);
            if ($ryMove ? $newValue < $bestValue : $newValue > $bestValue) {
                $bestMove = $move;
                $bestValue = $newValue;
                if ($this->shouldSendArrows) {
                    $this->apiHandler->clear();
                    $this->apiHandler->arrow($move[0], $move[1]);
                }
            }
            $board->undo();
        }
        return $bestMove;
    }

    /**
     * Initialize a minimax search.
     *
     * @param int           $depth The max search depth.
     * @param int           $alpha The alpha mix.     
     * @param int           $beta  The beta mix.
     * @param \Hikura\Board $board The board.
     *
     * @returns int The evaluation sum on the move.
     */
    private function minimax(int $depth, int $alpha, int $beta, Board $board): int
    {
        if ($depth === 0) {
            return -$this->evaluator->evaluate($board);
        }
        if ($board->ryMove()) {
            $bestValue = 99999;
            foreach ($board->getMoves() as $move) {
                $board->move($move);
                $bestValue = min($bestValue, $this->minimax($depth - 1, $alpha, $beta, $board));
                $board->undo();
                $beta = min($beta, $bestValue);
                if ($beta <= $alpha) {
                    return $bestValue;
                }
            }
        } else {
            $bestValue = -99999;
            foreach ($board->getMoves() as $move) {
                $board->move($move);
                $bestValue = max($bestValue, $this->minimax($depth - 1, $alpha, $beta, $board));
                $board->undo();
                $alpha = max($alpha, $bestValue);
                if ($beta <= $alpha) {
                    return $bestValue;
                }
            }
        }
        return $bestValue;
    }
}
