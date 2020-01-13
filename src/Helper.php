<?php

namespace Hikura;

/**
 * The helper extension.
 */
class Helper implements Extension
{
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

    /**
     * Parse the fen string.
     *
     * @param string $fen The fen string to parse.
     *
     * @return array Returns the parse fen into an array format.
     */
    public function parseFen(string $fen = ''): array
    {
        $fen = trim($fen);
        if ($fen === '') {
            return [];
        }
        $res = [];
        $fen = explode('-', $fen);
        $res['turn'] = $fen[0];
        $playDead = explode(',', $fen[1]);
        $res['gameOver'] = false;
        foreach ($playDead as $dead) {
            if ($dead === '1') {
                $res['gameOver'] = true;
                break;
            }
        }
        $ksCastlingRights = explode(',', $fen[2]);
        $qsCastlingRights = explode(',', $fen[3]);
        foreach ($ksCastlingRights as $ksKey => $ksRights) {
            if ($ksRights === '1') {
                $res['castlingRights']['kS'][$ksKey] = true;
            } else {
                $res['castlingRights']['kS'][$ksKey] = false;
            }
        }
        foreach ($qsCastlingRights as $qsKey => $qsRights) {
            if ($qsRights === '1') {
                $res['castlingRights']['qS'][$qsKey] = true;
            } else {
                $res['castlingRights']['qS'][$qsKey] = false;
            }
        }
        $possibleEnpassant = \substr($fen[6], 2, 9);
        if ($possibleEnpassant === 'enPassant') {
            $enpassantParts = explode(':', $fen[6]);
            $enpassantVars = rtrim(ltrim($enpassantParts[1], '{('), ')}');
            $pieces = explode(',', $enpassantVars);
            $opt = [];
            foreach ($pieces as $piece) {
                $opt[] = rtrim(ltrim($piece, '\''), '\'');
            }
            $res['enpassants'] = $opt;
            $boardFen = $fen[7];
        } else {
            $res['enpassants'] = ['', '', '', ''];
            $boardFen = $fen[6];
        }
        $board = [];
        $pieceCodes = [
            'rK' => [0, 5], 'bK' => [1, 5], 'yK' => [2, 5], 'gK' => [3, 5],
            'rQ' => [0, 4], 'bQ' => [1, 4], 'yQ' => [2, 4], 'gQ' => [3, 4],
            'rR' => [0, 3], 'bR' => [1, 3], 'yR' => [2, 3], 'gR' => [3, 3],
            'rB' => [0, 2], 'bB' => [1, 2], 'yB' => [2, 2], 'gB' => [3, 2],
            'rN' => [0, 1], 'bN' => [1, 1], 'yN' => [2, 1], 'gN' => [3, 1],
            'rP' => [0, 0], 'bP' => [1, 0], 'yP' => [2, 0], 'gP' => [3, 0],
        ];
        $ranks = explode('/', $boardFen);
        foreach ($ranks as $rank) {
            $squares = explode(',', $rank);
            foreach ($squares as $square) {
                if (array_key_exists($square, $pieceCodes)) {
                    $board[] = $pieceCodes[$square];
                } else {
                    $int = intval($square);
                    for ($i = 1; $i <= $int; $i++) {
                        $board[] = 0;
                    }
                }
            }
        }
        $res['board'] = $board;
        return $res;
    }
}
