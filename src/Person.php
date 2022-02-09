<?php


namespace App;


use App\Exceptions\WriteAccessDeniedException;

abstract class Person implements BoardObservable
{
    public int $id;
    public string $name;
    public ?Marker $marker = null;

    public function __construct(string $name)
    {
        $this->id = rand(1000, 9999);
        $this->name = $name;
    }

    public function writeOnBoard(Board $board, string $text)
    {
        if (!$this->marker)
            throw new WriteAccessDeniedException();

        $this->marker->write($board, $text);
    }

    public function revokeMarker()
    {
        $this->marker = null;
    }

    public function readBoard(Board $board)
    {
        // do something
    }
}