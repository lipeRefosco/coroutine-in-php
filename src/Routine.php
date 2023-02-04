<?php

namespace Lipe\PhpCoroutine;

use Generator;

final class Routine
{

    private State $state;
    private Generator $generator;

    function __construct(Generator $generator)
    {
        $this->state = State::Startup;
        $this->generator = $generator;
    }

    public function resolve(): void
    {
        if($this->state == State::Startup){
            $this->state = $this->current();
            return;
        }

        $this->state = $this->next();
        return;
    }

    private function current(): State
    {
        return $this->generator->current() ?? State::Running;
    }

    private function next(): State
    {
        $this->generator->next();
        
        $currentPositionIsValid = $this->generator->valid();

        return $currentPositionIsValid ? State::Running : State::Done;
    }

    public function state(): State 
    {
        return $this->state;
    }
}