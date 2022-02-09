<?php


namespace App;

use DateTime;

class AttendanceBook
{
    private ?DateTime $startedAt;
    private ?DateTime $endedAt;
    private Teacher $teacher;
    /** @var Student[] */
    private array $students;
    private array $joinLog = [];

    private function addJoinLog(Person $student)
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

    public function headCount()
    {
        return count($this->students);
    }

    public function joinStudent(Student $student): self
    {
        $this->students[] = $student;
        $this->addJoinLog($student);
        return $this;
    }

    public function joinTeacher(Teacher $teacher)
    {
        $teacher->setAttendanceBook($this);
        $this->addJoinLog($teacher);
        $this->teacher = $teacher;
    }
}