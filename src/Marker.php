<?php


namespace App;


class Marker
{
    public function write(Board $board, string $text)
    {
        $board->write($text);
    }
}