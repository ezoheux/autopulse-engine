<?php

namespace Hikura;

/**
 * The helper extension.
 */
class Helper implements Extension
{
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
            }
            $res['castlingRights']['kS'][$ksKey] = false;
        }
        foreach ($qsCastlingRights as $qsKey => $qsRights) {
            if ($qsRights === '1') {
                $res['castlingRights']['qS'][$qsKey] = true;
            }
            $res['castlingRights']['qS'][$qsKey] = false;
        }
        $possibleEnpassant = \substr($fen[5], 2, 9);
        if ($possibleEnpassant === 'enPassant') {
            $enpassantParts = explode(':', $fen[5]);
            $enpassantVars = rtrim(ltrim($enpassantParts[1], '{('), ')}');
            $pieces = explode(',', $enpassantVars);
            $opt = [];
            foreach ($pieces as $piece) {
                $opt[] = rtrim(ltrim($piece, '\''), '\'');
            }
            $res['enpassants'] = $opt;
            $boardFen = $fen[6];
        } else {
            $res['enpassants'] = ['', '', '', ''];
            $boardFen = $fen[5];
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
            $squares = explode(',', $ranks);
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
