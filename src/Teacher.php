<?php


namespace App;


class Teacher extends Person
{
    private ?AttendanceBook $attendanceBook;
    private array $writeRequests = [];

    public function __construct(string $name, Marker $marker)
    {
        parent::__construct($name);
        $this->marker = $marker;
    }

    public function addWriteRequest(Student $student)
    {
        $this->writeRequests[] = $student;
    }

    public function acceptWriteRequest(Student $student)
    {
        $index = array_search($student, $this->writeRequests);
        if ($index === false) return;
        $this->assignMaker($student);
        array_splice($this->writeRequests, $index, 1);
    }

    public function setAttendanceBook(AttendanceBook $attendanceBook)
    {
        $this->attendanceBook = $attendanceBook;
    }

    public function assignMaker(Student $student)
    {
        $student->marker = $this->marker;
        $this->revokeMarker();
    }

    public function takeBackMarker(Student $student)
    {
        $this->marker = $student->marker;
        $student->revokeMarker();
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