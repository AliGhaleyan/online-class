<?php


namespace App;


class Board
{
    private string $area = "";
    /** @var BoardObservable[] */
    private array $subscribers = [];

    public function addSubscriber(BoardObservable $subscriber): self
    {
        $this->subscribers[] = $subscriber;
        return $this;
    }

    public function removeSubscriber(BoardObservable $subscriber)
    {
        $index = array_search($subscriber, $this->subscribers);
        if ($index === false) return;
        array_splice($this->subscribers, $index, 1);
    }

    public function write(string $text)
    {
        $this->area .= $text;
        $this->readNotify();
    }

    public function readNotify()
    {
        foreach ($this->subscribers as $subscriber)
            $subscriber->readBoard($this);
    }

    public function read()
    {
        return $this->area;
    }

    public function clear()
    {
        $this->area = "";
    }
}