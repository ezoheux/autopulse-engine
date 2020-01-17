<?php

namespace Hikura;

/**
 * Any extra variables and functions needed for proper function.
 */
class Helper
{
    /** @var array $colorsReturn Revert the numeric color value back to its string repensentation. */
    private $colorsReturn = ['R', 'B', 'Y', 'G',];

    /** @var array $piecesReturn Revert the numeric piece value back to its string repensentation. */
    private $piecesReturn = ['P', 'N', 'B', 'R', 'Q', 'K',];

    /** @var array $colors Convert the colors to a numeric repensation. */
    private $colors = ['R' => 0, 'B' => 1, 'Y' => 2, 'G' => 3,];

    /** @var array $enpassants The enpassant codes. */
    public $enpassants = ['R' => '-', 'B' => '-', 'Y' => '-', 'G' => '-',];

    /** @var array $convertPromotionPiece Convert the promotion piece. */
    public $convertPromotionPiece = ['N' => 1, 'B' => 2, 'R' => 3, 'Q' => 4,];

    /** @var array $rookSquare The rook to & from squares (kingside, queenside). */
    public $rookSquares = [
        'h1'  => ['f1'  => ['g1',  'd1', ], 'j1'  => ['i1',  'k1', ],],
        'a8'  => ['a6'  => ['a7',  'a4', ], 'a10' => ['a9',  'a11',],],
        'g14' => ['i14' => ['h14', 'k14',], 'e14' => ['f14', 'd14',],],
        'n7'  => ['n9'  => ['n8',  'n11',], 'n5'  => ['n6',  'n4', ],],
    ];

    /** @var array The castling rights. */
    public $castling = [
        'h1'  => ['f1'  => true, 'j1'  => true,],
        'a8'  => ['a6'  => true, 'a10' => true,],
        'g14' => ['i14' => true, 'e14' => true,],
        'n7'  => ['n9'  => true, 'n5'  => true,],
    ];

    /** @var array $moveTwoSquares A list of square to allow two space moves for pawns.*/
    private $moveTwoSquares = [
        'd2',  'e2',  'f2',  'g2',  'h2',  'i2',  'j2',  'k2',
        'b4',  'b5',  'b6',  'b7',  'b8',  'b9',  'b10', 'b11',
        'd13', 'e13', 'f13', 'g13', 'h13', 'i13', 'j13', 'k13',
        'm4',  'm5',  'm6',  'm7',  'm8',  'm9',  'm10', 'm11',
    ];

    /** @var array $opositeColors The list of opposite colors. */
    public $oppositeColors = [
        'R' => [
            'B',
            'G',
        ],
        'B' => [
            'R',
            'Y',
        ],
        'Y' => [
            'B',
            'G',
        ],
        'G' => [
            'R',
            'Y',
        ],
    ];

    /** @var array $convertLetters Translate a letter to a number. */
    private $convertLetters = [
        'a' => 1, 'b' => 2, 'c' => 3,  'd' => 4,  'e' => 5,  'f' => 6,  'g' => 7,
        'h' => 8, 'i' => 9, 'j' => 10, 'k' => 11, 'l' => 12, 'm' => 13, 'n' => 14,
    ];

    /** @var array $convertNumbers Translate a number to a letter. */
    private $convertNumbers = [
        1  => 'a', 2  => 'b', 3  => 'c', 4  => 'd', 5  => 'e', 6  => 'f', 7  => 'g',
        8  => 'h', 9  => 'i', 10 => 'j', 11 => 'k', 12 => 'l', 13 => 'm', 14 => 'n',
    ];

    /**
     * @var array $promotionSquares The promotion squares.
     */
    public $promotionSquares = [
        'R' => [
            'a11', 'b11', 'c11', 'd11', 'e11', 'f11', 'g11',
            'h11', 'i11', 'j11', 'k11', 'l11', 'm11', 'n11',
        ],
        'B' => [
            'k1',  'k2',  'k3',  'k4',  'k5',  'k6',  'k7',
            'k8',  'k9',  'k10', 'k11', 'k12', 'k13', 'k14',
        ],
        'Y' => [
            'a4',  'b4',  'c4',  'd4',  'e4',  'f4',  'g4',
            'h4',  'i4',  'j4',  'k4',  'l4',  'm4',  'n4',
        ],
        'G' => [
            'd1',  'd2',  'd3',  'd4',  'd5',  'd6',  'd7',
            'd8',  'd9',  'd10', 'd11', 'd12', 'd13', 'd14',
        ],
    ];

    /** @var string $turn The current move turn. */
    public $turn = 'R';

    /** @var int $moveNumber The move number. */
    public $moveNumber = 1;

    /** @var int $halfMoves The move number. */
    public $halfMoves = 0;

    /** @var array $numericAlphabeticSquares The 4 player chess numeric alphabetic squares. */
    private $numericAlphabeticSquares = [
                             'd14', 'e14', 'f14', 'g14', 'h14', 'i14', 'j14', 'k14',
                             'd13', 'e13', 'f13', 'g13', 'h13', 'i13', 'j13', 'k13',
                             'd12', 'e12', 'f12', 'g12', 'h12', 'i12', 'j12', 'k12',
        'a11', 'b11', 'c11', 'd11', 'e11', 'f11', 'g11', 'h11', 'i11', 'j11', 'k11', 'l11', 'm11', 'n11',
        'a10', 'b10', 'c10', 'd10', 'e10', 'f10', 'g10', 'h10', 'i10', 'j10', 'k10', 'l10', 'm10', 'n10',
        'a9',  'b9',  'c9',  'd9',  'e9',  'f9',  'g9',  'h9',  'i9',  'j9',  'k9',  'l9',  'm9',  'n9',
        'a8',  'b8',  'c8',  'd8',  'e8',  'f8',  'g8',  'h8',  'i8',  'j8',  'k8',  'l8',  'm8',  'n8',
        'a7',  'b7',  'c7',  'd7',  'e7',  'f7',  'g7',  'h7',  'i7',  'j7',  'k7',  'l7',  'm7',  'n7',
        'a6',  'b6',  'c6',  'd6',  'e6',  'f6',  'g6',  'h6',  'i6',  'j6',  'k6',  'l6',  'm6',  'n6',
        'a5',  'b5',  'c5',  'd5',  'e5',  'f5',  'g5',  'h5',  'i5',  'j5',  'k5',  'l5',  'm5',  'n5',
        'a4',  'b4',  'c4',  'd4',  'e4',  'f4',  'g4',  'h4',  'i4',  'j4',  'k4',  'l4',  'm4',  'n4',
                             'd3',  'e3',  'f3',  'g3',  'h3',  'i3',  'j3',  'k3',
                             'd2',  'e2',  'f2',  'g2',  'h2',  'i2',  'j2',  'k2',
                             'd1',  'e1',  'f1',  'g1',  'h1',  'i1',  'j1',  'k1',
    ];

    /** @var array $board The 4 player chess board. */
    public $board = [
        [2, 3,], [2, 1,], [2, 2,], [2, 5,], [2, 4,], [2, 2,], [2, 1,], [2, 3,],
        [2, 0,], [2, 0,], [2, 0,], [2, 0,], [2, 0,], [2, 0,], [2, 0,], [2, 0,],
                             0, 0, 0, 0, 0, 0, 0, 0,
        [1, 3,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 3,], 
        [1, 1,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 1,],
        [1, 2,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 2,],
        [1, 5,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 4,],
        [1, 4,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 5,],
        [1, 2,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 2,],
        [1, 1,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 1,],
        [1, 3,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 3,],
                             0, 0, 0, 0, 0, 0, 0, 0,
        [0, 0,], [0, 0,], [0, 0,], [0, 0,], [0, 0,], [0, 0,], [0, 0,], [0, 0,],
        [0, 3,], [0, 1,], [0, 2,], [0, 4,], [0, 5,], [0, 1,], [0, 2,], [0, 3,],
    ];

    /** @var array $standardBoard The standard 4 player chess board. */
    public $standardBoard = [
        [2, 3,], [2, 1,], [2, 2,], [2, 5,], [2, 4,], [2, 2,], [2, 1,], [2, 3,],
        [2, 0,], [2, 0,], [2, 0,], [2, 0,], [2, 0,], [2, 0,], [2, 0,], [2, 0,],
                             0, 0, 0, 0, 0, 0, 0, 0,
        [1, 3,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 3,], 
        [1, 1,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 1,],
        [1, 2,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 2,],
        [1, 5,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 4,],
        [1, 4,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 5,],
        [1, 2,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 2,],
        [1, 1,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 1,],
        [1, 3,], [1, 0,], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, [3, 0,], [3, 3,],
                             0, 0, 0, 0, 0, 0, 0, 0,
        [0, 0,], [0, 0,], [0, 0,], [0, 0,], [0, 0,], [0, 0,], [0, 0,], [0, 0,],
        [0, 3,], [0, 1,], [0, 2,], [0, 4,], [0, 5,], [0, 1,], [0, 2,], [0, 3,],
    ];

    /**
     * Get the next colors turn.
     *
     * @param string The current color.
     *
     * @return string Returns the next color.
     */
    public function nextColor(string $color): string
    {
        return $this->colorsReturn[(($this->colors[$color] + 1) % 4)];
    }

    /**
     * Get the next colors turn.
     *
     * @param string The current color.
     *
     * @return void Returns nothing.
     */
    public function optimizeEnpassant(string $color): void
    {
        $this->enpassants[$this->nextColor($color)] = '-';
    }

    /**
     * Force set an enpassant value.
     *
     * @param string $value The new enpassant value.
     *
     * @return void Return nothing.
     */
    public function setEnpassant(string $color, string $value = '-'): void
    {
        $this->enpassants[$color] = $value;
    }

    /**
     * Get enpassant array.
     *
     * @return array Returns the enpassant array.
     */
    public function getEnpassant(): array
    {
        return $this->enpassants;
    }

    /**
     * Get the square info.
     *
     * @param string $square The square to check.
     *
     * @return mixed Returns the square data or false.
     */
    public function getSquareInfo($square) {
        $numericSquare = $this->isNotOffBoardSquare($square);
        if (!is_int($numericSquare)) {
            return false;
        }
        $info = [];
        $info['numeral'] = $numericSquare;
        if ($this->isEmptySquare($square)) {
            $info['color'] = null;
            $info['piece'] = null;
        } else {
            $info['color'] = $this->colorsReturn[$this->board[$numericSquare][0]];
            $info['piece'] = $this->piecesReturn[$this->board[$numericSquare][1]];
        }
        return $info;
    }

    /**
     * Check to see if the square is off board.
     *
     * @param string $square The square to work with.
     *
     * @return bool Returns true if the square is empty or false.
     */
    public function isEmptySquare(string $square): bool
    {
        $numericSquare = $this->isNotOffBoardSquare($square);
        if (is_int($numericSquare)) {
            return !is_array($this->board[$numericSquare]);
        }
        return false;
    }

    /**
     * Check to see if the square is off board.
     *
     * @param string $square The square to work with.
     *
     * @return mixed Returns the off board response.
     */
    public function isNotOffBoardSquare(string $square)
    {
        return array_search($square, $this->numericAlphabeticSquares);
    }

    /**
     * Check to see if both squares match a king threat.
     *
     * @param string $square1 The square1 to work with.
     * @param string $square2 The square2 to work with.
     *
     * @return bool Returns the threat response.
     */
    public function isKingThreat(string $square1, string $square2): bool
    {
        $x1 = $this->convertLetters[$square1[0]];
        $x2 = $this->convertLetters[$square2[0]];
        $y1 = intval(substr($square1, 1));
        $y2 = intval(substr($square2, 1));
        if ($x1 > $x2) {
            $spaces_1 = $x1 - $x2;
            if ($spaces_1 != 1) {
                return false;
            }
        }
        if ($x2 > $x1) {
            $spaces_2 = $x2 - $x1;
            if ($spaces_2 != 1) {
                return false;
            }
        }
        if ($y1 > $y2) {
            $spaces_3 = $y1 - $y2;
            if ($spaces_3 != 1) {
                return false;
            }
        }
        if ($y2 > $y1) {
            $spaces_4 = $y2 - $y1;
            if ($spaces_4 != 1) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check to see if both squares match a queen threat.
     *
     * @param string $square1 The square1 to work with.
     * @param string $square2 The square2 to work with.
     *
     * @return bool Returns the threat response.
     */
    public function isQueenThreat(string $square1, string $square2): bool
    {
        return $this->isRookThreat($square1, $square2) || $this->isBishopThreat($square1, $square2);
    }

    /**
     * Check to see if both squares match a rook threat.
     *
     * @param string $square1 The square1 to work with.
     * @param string $square2 The square2 to work with.
     *
     * @return bool Returns the threat response.
     */
    public function isRookThreat(string $square1, string $square2): bool
    {
        $x1 = $this->convertLetters[$square1[0]];
        $x2 = $this->convertLetters[$square2[0]];
        $y1 = intval(substr($square1, 1));
        $y2 = intval(substr($square2, 1));
        if ($x1 == $x2) {
            if ($y1 > $y2) {
                $spaces = $y1 - $y2;
                if ($spaces > 1) {
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1;
                        $y = strval($y1 - $i);
                        if (!$this->isEmptySquare($this->convertNumbers[$x] . $y)) {
                            return false;
                        }
                        $spaces--;
                        $i++;
                    }
                }
                return true;
            }
            if ($y2 > $y1) {
                $spaces = $y2 - $y1;
                if ($spaces > 1) {
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1;
                        $y = strval($y1 + $i);
                        if (!$this->isEmptySquare($this->convertNumbers[$x] . $y)) {
                            return false;
                        }
                        $spaces--;
                        $i++;
                    }
                }
                return true;
            }
        } elseif ($y1 == $y2) {
            if ($x1 > $x2) {
                $spaces = $x1 - $x2;
                if ($spaces > 1) {
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1 - $i;
                        $y = strval($y1);
                        if (!$this->isEmptySquare($this->convertNumbers[$x] . $y)) {
                            return false;
                        }
                        $spaces--;
                        $i++;
                    }
                }
                return true;
            }
            if ($x2 > $x1) {
                $spaces = $x2 - $x1;
                if ($spaces > 1) {
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1 + $i;
                        $y = strval($y1);
                        if (!$this->isEmptySquare($this->convertNumbers[$x] . $y)) {
                            return false;
                        }
                        $spaces--;
                        $i++;
                    }
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Check to see if both squares match a bishop threat.
     *
     * @param string $square1 The square1 to work with.
     * @param string $square2 The square2 to work with.
     *
     * @return bool Returns the threat response.
     */
    public function isBishopThreat(string $square1, string $square2): bool
    {
        $x1 = $this->convertLetters[$square1[0]];
        $x2 = $this->convertLetters[$square2[0]];
        $y1 = intval(substr($square1, 1));
        $y2 = intval(substr($square2, 1));
        if ($x1 > $x2) {
            $spaces_x = $x1 - $x2;
            if ($y1 > $y2) {
                $spaces_y = $y1 - $y2;
                if ($spaces_x == $spaces_y) {
                    $spaces = $spaces_x;
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1 - $i;
                        $y = strval($y1 - $i);
                        if (!$this->isEmptySquare($this->convertNumbers[$x] . $y)) {
                            return false;
                        }
                        $spaces--;
                        $i++;
                    }
                    return true;
                }
            }
            if ($y2 > $y1) {
                $spaces_y = $y2 - $y1;
                if ($spaces_x == $spaces_y) {
                    $spaces = $spaces_x;
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1 - $i;
                        $y = strval($y1 + $i);
                        if (!$this->isEmptySquare($this->convertNumbers[$x] . $y)) {
                            return false;
                        }
                        $spaces--;
                        $i++;
                    }
                    return true;
                }
            }
            return false;
        } elseif ($x2 > $x1) {
            $spaces_x = $x2 - $x1;
            if ($y1 > $y2) {
                $spaces_y = $y1 - $y2;
                if ($spaces_x == $spaces_y) {
                    $spaces = $spaces_x;
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1 + $i;
                        $y = strval($y1 - $i);
                        if (!$this->isEmptySquare($this->convertNumbers[$x] . $y)) {
                            return false;
                        }
                        $spaces--;
                        $i++;
                    }
                    return true;
                }
            }
            if ($y2 > $y1) {
                $spaces_y = $y2 - $y1;
                if ($spaces_x == $spaces_y) {
                    $spaces = $spaces_x;
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1 + $i;
                        $y = strval($y1 + $i);
                        if (!$this->isEmptySquare($this->convertNumbers[$x] . $y)) {
                            return false;
                        }
                        $spaces--;
                        $i++;
                    }
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Check to see if both squares match a knight threat.
     *
     * @param string $square1 The square1 to work with.
     * @param string $square2 The square2 to work with.
     *
     * @return bool Returns the threat response.
     */
    public function isKnightThreat(string $square1, string $square2): bool
    {
        $letterA = $this->convertLetters[$square1[0]];
        $letterB = $this->convertLetters[$square2[0]];
        $numberA = intval(substr($square1, 1));
        $numberB = intval(substr($square2, 1));
        $xA = $letterA + 2;
        $xB = $letterA - 2;
        $yA = $numberA + 1;
        $yB = $numberA - 1;
        if ($xA == $letterB && $yA == $numberB ||
            $xA == $letterB && $yB == $numberB ||
            $xB == $letterB && $yA == $numberB ||
            $xB == $letterB && $yB == $numberB) {
            return true;
        }
        $xA = $letterA + 1;
        $xB = $letterA - 1;
        $yA = $numberA + 2;
        $yB = $numberA - 2;
        if ($yA == $numberB && $xA == $letterB ||
            $yA == $numberB && $xB == $letterB ||
            $yB == $numberB && $xA == $letterB ||
            $yB == $numberB && $xB == $letterB) {
            return true;
        }
        return false;
    }
