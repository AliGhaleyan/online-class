<?php

use App\Board;
use App\Marker;
use App\Student;
use App\Teacher;
use App\AttendanceBook;
use Faker\Factory;
use Faker\Generator;
use App\Exceptions\WriteAccessDeniedException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ClassRoomTest extends TestCase
{
    private Generator $faker;

    public function test_teacher_write_on_the_board()
    {
        $board = new Board();
        $teacher = new Teacher($this->faker->name, new Marker());
        $teacher->writeOnBoard($board, "Hello World!");
        $this->assertEquals($board->read(), "Hello World!");
    }

    public function test_every_one_can_read_board()
    {
        $board = new Board();
        $student = $this->makeStudentMock();
        $student->expects($this->once())->method("readBoard")->with($board);
        $teacher = new Teacher($this->faker->name, new Marker());
        $board->addSubscriber($teacher)
            ->addSubscriber($student);
        $teacher->writeOnBoard($board, "Hello World!");
    }

    /**
     * @param string|null $name
     * @return MockObject|Student
     */
    protected function makeStudentMock(string $name = null)
    {
        if (!$name) $name = $this->faker->name;
        return $this->getMockBuilder(Student::class)->setConstructorArgs([$name])->getMock();
    }

    public function test_student_ask_write_permission()
    {
        $marker = new Marker();
        $teacher = new Teacher($this->faker->name, $marker);
        $student = new Student($this->faker->name);
        $student->requestToWrite($teacher);
        $teacher->acceptWriteRequest($student);
        $this->assertEquals($student->marker, $marker);
        $this->assertEquals($teacher->marker, null);
    }

    public function test_teacher_take_back_write_permission()
    {
        $marker = new Marker();
        $teacher = new Teacher($this->faker->name, $marker);
        $student = new Student($this->faker->name);
        $student->requestToWrite($teacher);
        $teacher->acceptWriteRequest($student);
        // Student write something
        $teacher->takeBackMarker($student);
        $this->assertEquals($student->marker, null);
        $this->assertEquals($teacher->marker, $marker);
    }

    public function test_student_finished_write_on_the_board()
    {
        $marker = new Marker();
        $teacher = new Teacher($this->faker->name, $marker);
        $student = new Student($this->faker->name);
        $student->requestToWrite($teacher);
        $teacher->acceptWriteRequest($student);
        // Student write something
        $student->giveBackMarker($teacher);
        $this->assertEquals($student->marker, null);
        $this->assertEquals($teacher->marker, $marker);
    }

    public function test_only_one_person_can_write_on_the_board_at_a_time()
    {
        $marker = new Marker();
        $board = new Board();
        $teacher = new Teacher($this->faker->name, $marker);
        $student1 = new Student($this->faker->name);
        $student2 = new Student($this->faker->name);
        $student1->requestToWrite($teacher);
        $teacher->acceptWriteRequest($student1);
        $student1->writeOnBoard($board, "Hello World!");
        $this->expectException(WriteAccessDeniedException::class);
        $student2->writeOnBoard($board, "Hello Guys!");
    }

    public function test_student_head_count()
    {
        $students = $this->makeFakeStudents(10);
        $attendanceBook = new AttendanceBook(new DateTime());
        $attendanceBook->start();
        foreach ($students as $student)
            $attendanceBook->joinStudent($student);
        $this->assertEquals($attendanceBook->headCount(), 10);
    }

    public function test_student_late_head_count()
    {
        $students = $this->makeFakeStudents(10);
        $datetime = new DateTime();
        $datetime->modify("-10 minutes");
        $attendanceBook = new AttendanceBook($datetime);
        $attendanceBook->startedAt = $datetime;
        foreach ($students as $student)
            $attendanceBook->joinStudent($student);

        $this->assertEquals($attendanceBook->headCount(),  0);
    }

    public function test_teacher_start_and_end_teaching()
    {
        $marker = new Marker();
        $teacher = new Teacher($this->faker->name, $marker);
        $attendanceBook = new AttendanceBook(new DateTime());
        $teacher->setAttendanceBook($attendanceBook);
        $teacher->startTeaching();
        $teacher->endTeaching();
        $this->assertNotNull($attendanceBook->startedAt);
        $this->assertNotNull($attendanceBook->endedAt);
    }

    public function test_teacher_late()
    {
        $this->expectException(\App\Exceptions\ClassStartedLateException::class);
        $marker = new Marker();
        $teacher = new Teacher($this->faker->name, $marker);
        $datetime = new DateTime();
        $datetime->modify("-31 minutes");
        $attendanceBook = new AttendanceBook($datetime);
        $teacher->setAttendanceBook($attendanceBook);
        $teacher->startTeaching();
    }

    /**
     * @param string|null $name
     * @return MockObject|Teacher
     */
    protected function makeTeacherMock(string $name = null)
    {
        if (!$name) $name = $this->faker->name;
        return $this->getMockBuilder(Teacher::class)->setConstructorArgs([$name])->getMock();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    protected function makeFakeStudents(int $count): array
    {
        $students = [];
        for ($i = 0; $i < $count; $i++)
            $students[] = new Student($this->faker->name);

        return $students;
    }
}