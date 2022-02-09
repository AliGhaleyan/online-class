<?php


namespace App;


class Teacher extends Person
{
    private ?AttendanceBook $attendanceBook;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->marker = new Marker();
        $this->marker->setOwner($this);
        $this->marker->setWriter($this);
    }

    public function setAttendanceBook(AttendanceBook $attendanceBook)
    {
        $this->attendanceBook = $attendanceBook;
    }

    public function assignMaker(Student $student)
    {
        $this->marker->setWriter($student);
        $student->marker = $this->marker;
    }

    public function revokeMarker(Student $student)
    {
        $student->marker = null;
        $this->marker->setWriter($this);
    }

    public function startTeaching()
    {
        $this->attendanceBook->start();
    }

    public function endTeaching()
    {
        $this->attendanceBook->end();
    }
}