<?php

use App\ClassRoom;
use App\Student;
use App\Teacher;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class ClassRoomTest extends TestCase
{
    private Generator $faker;

    public function test_teacher_write_on_the_board()
    {
        $teacher = new Teacher($this->faker->name);
        $classRoom = new ClassRoom($teacher);
        $teacher->writeOnBoard("Teacher write");
        $this->assertEquals($classRoom->readBoard(), "Teacher write");
    }

    public function test_every_one_can_read_board()
    {
        //
    }

    public function test_student_ask_write_permission()
    {
        //
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
        $this->faker = $faker = Factory::create();
    }

    protected function makeFakeStudents(int $count = 10): array
    {
        $students = [];
        for ($i = 0; $i < $count; $i++)
            $students[] = new Student($this->faker->name);

        return $students;
    }
}