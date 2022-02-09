<?php

use App\Board;
use App\Student;
use App\Teacher;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ClassRoomTest extends TestCase
{
    private Generator $faker;

    public function test_teacher_write_on_the_board()
    {
        $board = new Board();
        $teacher = $this->makeTeacher();
        $teacher->writeOnBoard($board, "Hello World!");
        $this->assertEquals($board->read(), "Hello World!");
    }

    public function test_every_one_can_read_board()
    {
        $board = new Board();
        $student = $this->makeStudentMock();
        $student->expects($this->once())->method("readBoard")->with($board);
        $teacher = $this->makeTeacher();
        $board->addSubscriber($teacher)
            ->addSubscriber($student);
        $teacher->writeOnBoard($board, "Hello World!");
    }

    public function test_student_ask_write_permission()
    {
        $board = new Board();
        $teacher = $this->makeTeacher();
        $student = $this->makeStudent();
        $teacher->assignMaker($student);
        $student->writeOnBoard($board, "Hello World!");
    }

    public function test_teacher_take_back_write_permission()
    {
        //
    }

    public function test_student_finished_write_on_the_board()
    {
        //
    }

    public function test_only_one_person_can_write_on_the_board_at_a_time()
    {
        //
    }

    public function test_student_head_count()
    {
        //
    }

    public function test_student_late_head_count()
    {
        //
    }

    public function test_teacher_late()
    {
        //
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    protected function makeFakeStudents(int $count = 10): array
    {
        $students = [];
        for ($i = 0; $i < $count; $i++)
            $students[] = $this->makeStudent();

        return $students;
    }

    protected function makeTeacher()
    {
        return new Teacher($this->faker->name);
    }

    protected function makeStudent()
    {
        return new Student($this->faker->name);
    }

    /**
     * @return MockObject|Student
     */
    protected function makeStudentMock()
    {
        return $this->getMockBuilder(Student::class)
            ->setConstructorArgs([$this->faker->name])
            ->getMock();
    }
}