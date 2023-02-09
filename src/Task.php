<?php

namespace Lipe\PhpCoroutine;

use Generator;

final class Task
{

    private State $state;
    private Generator $generator;

    function __construct(callable $generator, ...$params)
    {
        $this->state = State::Startup;
        $this->generator = $generator(...$params);
    }

    public function resolve(): Generator
    {
        if($this->isStarted()) { 
            $this->state = $this->current();
            return yield;
        }

        $this->state = $this->isValid() ? $this->next() : State::Done;

        return yield;
    }

    private function current(): State
    {
        return $this->generator->current() ?? State::Running;
    }

    private function next(): State
    {
        $this->generator->next();
        return $this->current() ?? State::Running;
    }

    public function pause(): void
    {
        $this->state = State::Paused;
    }

    public function state(): State 
    {
        return $this->state;
    }

    public function isStarted(): bool
    {
        return $this->state == State::Startup;
    }

    public function isRunning(): bool
    {
        return $this->state == State::Running;
    }

    public function isPaused(): bool
    {
        return $this->state == State::Paused;
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