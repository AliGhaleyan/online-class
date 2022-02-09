<?php


namespace App;


class Marker
{
    protected Teacher $owner;
    public ?Person $writer = null;

    public function write(Board $board, string $text)
    {
        $board->write($text);
    }

    public function setOwner(Teacher $owner)
    {
        $this->owner = $owner;
    }

    public function setWriter(Person $writer)
    {
        $this->writer = $writer;
    }
}