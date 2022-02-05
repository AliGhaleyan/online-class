<?php


namespace App;


abstract class Person
{
    public int $id;
    public string $name;
    protected ?Pencil $pencil = null;

    public function __construct(string $name)
    {
        $this->id = time();
        $this->name = $name;
    }

    public function givePencil(Pencil $pencil): self
    {
        $this->pencil = $pencil;
        return $this;
    }

    public function takePencil()
    {
        $this->pencil = null;
    }

    public function writeOnBoard(string $text)
    {
        if (!$this->pencil) throw new \Exception("You can not write on the board.");

        $this->pencil->write($text);
    }
}