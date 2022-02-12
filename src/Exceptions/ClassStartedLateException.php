<?php


namespace App\Exceptions;


class ClassStartedLateException extends \Exception
{
    protected $message = "The class started late.";
}