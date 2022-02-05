<?php


namespace App;


class Pencil
{
    private Board $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    public function write(string $text): self
    {
        $this->board->write($text);
        return $this;
    }
}