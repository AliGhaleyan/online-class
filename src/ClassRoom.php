<?php


namespace App;

use DateTime;

class ClassRoom
{
    public ?DateTime $startedAt = null;
    public ?DateTime $endedAt = null;

    private Board $board;
    private Teacher $teacher;
    private Pencil $pencil;
    private ?Person $writer;
    /** @var Student[] */
    private array $students;
    private array $joinLog = [];

    public function __construct(Teacher $teacher, $students = [])
    {
        $this->board = new Board();
        $this->pencil = new Pencil($this->board);
        $this->teacher = $teacher;
        $this->students = $students;
        $this->teacher->givePencil($this->pencil);
        $this->writer = $this->teacher;

        foreach ($students as $student)
            $this->addJoinLog($student);
    }

    private function addJoinLog(Student $student)
    {
        $this->joinLog[$student->id] = new DateTime();
    }

    public function start()
    {
        $this->startedAt = new DateTime();
    }

    public function end()
    {
        $this->endedAt = new DateTime();
    }

    public function join(Student $student): self
    {
        $this->students[] = $student;
        $this->addJoinLog($student);
        return $this;
    }

    public function setWriter(Person $person): self
    {
        if ($this->writer)
            $this->writer->takePencil();

        $person->givePencil($this->pencil);
        $this->writer = $person;
        return $this;
    }

    public function readBoard()
    {
        return $this->board->read();
    }
}