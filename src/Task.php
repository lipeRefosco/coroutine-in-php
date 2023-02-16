<?php

namespace Lipe\PhpCoroutine;

use Generator;

final class Task
{
    private State $state;
    private Generator $generator;

    function __construct(callable $userCallable, $params)
    {
        $this->state = State::Startup;
        $this->generator = $userCallable($this, $params);
    }

    public function resolve(): Generator
    {
        if($this->isStarted()) { 
            $this->state = $this->current();
            yield;
        }

        $this->state = $this->isValid() ? $this->next() : State::Done;
        yield;
    }

    private function current(): State
    {
        return $this->generator->current() ?? State::Running;
    }

    public function next(): State
    {
        $this->generator->next();
        return $this->current() ?? State::Running;
    }

    public function isStarted(): bool
    {
        return $this->state == State::Startup;
    }

    public function isRunning(): bool
    {
        return $this->state == State::Running;
    }

    public function isDone(): bool
    {
        return $this->state == State::Done;
    }

    private function isValid(): bool
    {
        return $this->generator->valid();
    }
}