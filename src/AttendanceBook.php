<?php


namespace App;

use App\Exceptions\ClassNotStartedException;
use App\Exceptions\ClassStartedLateException;
use DateTime;

class AttendanceBook
{
    private DateTime $openAt;
    public ?DateTime $startedAt = null;
    public ?DateTime $endedAt = null;
    private ?DateTime $teacherJoinedAt = null;
    private Teacher $teacher;
    /** @var Student[] */
    private array $students;
    private array $joinHistory = [];

    const START_LATE_MINUTES = 30;
    const STUDENT_JOIN_LATE_MINUTES = 10;

    public function __construct(DateTime $openAt)
    {
        $this->openAt = $openAt;
    }

    public function start()
    {
        $datetime = new DateTime();
        $openAt = $this->openAt;
        $minutes = self::START_LATE_MINUTES;
        $openAt->modify("+{$minutes} minutes");
        if ($datetime->getTimestamp() > $openAt->getTimestamp()) throw new ClassStartedLateException();
        $this->startedAt = new DateTime();
    }

    public function end()
    {
        $this->endedAt = new DateTime();
    }

    public function headCount()
    {
        $count = 0;
        $startedAt = $this->startedAt;
        if (!$startedAt) throw new ClassNotStartedException();

        $minutes = self::STUDENT_JOIN_LATE_MINUTES;
        $startedAt->modify("+{$minutes} minutes");
        /** @var DateTime $item */
        foreach ($this->joinHistory as $item) {
            if ($startedAt->getTimestamp() > $item->getTimestamp())
                $count++;
        }
        return $count;
    }

    public function joinStudent(Student $student): self
    {
        $this->students[] = $student;
        $this->addJoinHistory($student);
        return $this;
    }

    private function addJoinHistory(Student $student)
    {
        $this->joinHistory[$student->id] = new DateTime();
    }

    public function joinTeacher(Teacher $teacher)
    {
        $teacher->setAttendanceBook($this);
        $this->teacherJoinedAt = new DateTime();
        $this->teacher = $teacher;
    }
}