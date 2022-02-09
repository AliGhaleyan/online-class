<?php


namespace App;


abstract class Person implements BoardObservable
{
    public int $id;
    public string $name;
    public ?Marker $marker = null;

    public function __construct(string $name)
    {
        $this->id = rand(1000,9999);
        $this->name = $name;
    }

    public function writeOnBoard(Board $board, string $text)
    {
        if (!$this->marker) throw new \Exception("You can not write on board.");
        if ($this->marker->writer->id != $this->id)
            throw new \Exception("You can not write with this marker.");

        $this->marker->write($board, $text);
    }

    public function readBoard(Board $board)
    {
        // do something
    }
}