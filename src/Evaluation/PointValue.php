<?php

namespace Hikura\Evaluation;

/**
 * Defines how valuable a piece is.
 */
interface PointValue
{
    /** @const int PAWN The value of an pawn. */
    public const PAWN = 100;

    /** @const int KNIGHT The value of an knight. */
    public const KNIGHT = 350;

    /** @const int BISHOP The value of an bishop. */
    public const BISHOP = 475;

    /** @const int ROOK The value of an rook. */
    public const ROOK = 525;

    /** @const int QUEEN The value of an queen. */
    public const QUEEN = 1000;

    /** @const int KING The value of an king. */
    public const KING = 10000;
}
