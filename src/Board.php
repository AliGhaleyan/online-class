<?php


namespace App;


class Board
{
    private string $area = "";

    public function write(string $text)
    {
        $this->area .= $text;
    }

    public function read()
    {
        return $this->area;
    }

    public function clear()
    {
        $this->area = "";
    }
}