<?php


namespace App;


interface BoardObservable
{
    public function readBoard(Board $board);
}