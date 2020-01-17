<?php

namespace Hikura;

/**
 * The actual game controller.
 */
class Board
{
    /** @var array $history The current game history. */
    private $history = [];
 
    /**
     * Construct a new 4 player chess game.
     *
     * @param Helper $helper The helper class.
     *
     * @return void Returns nothing.
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }
    
    /**
     * Determine if it RY to move or not.
     *
     * @return bool Returns true if it's RY to move and false if not.
     */
    public function ryMove(): bool
    {
        return $this->helper->turn === 'R' || $this->helper->turn === 'Y';
    }
}
