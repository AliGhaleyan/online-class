<?php


namespace App\Exceptions;


class WriteAccessDeniedException extends \Exception
{
    protected $message = "Write access denied.";
}