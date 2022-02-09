<?php


namespace App;


class Student extends Person
{
    public function requestToWrite(Teacher $teacher)
    {
        $teacher->addWriteRequest($this);
    }

    public function giveBackMarker(Teacher $teacher)
    {
        $teacher->marker = $this->marker;
        $this->revokeMarker();
    }
}