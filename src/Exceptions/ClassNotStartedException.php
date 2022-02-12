<?php


namespace App\Exceptions;


class ClassNotStartedException extends \Exception
{
    protected $message = "The class has not started yet.";
}