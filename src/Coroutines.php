<?php

namespace Lipe\PhpCoroutine;

class Coroutines
{
    static private array $routines;


    static function Add(callable $newRoutine, mixed ...$params): void
    {
        self::$routines[] = new Task($newRoutine, $params);
    }

    static function ResolveAll(): void
    {
        foreach (self::$routines as $position => $routine) {
            $routine->resolve();
            self::ClearIfDone($routine->state(), $position);
        }
    }

    static function Remove($routinePositon): void
    {
        unset(self::$routines[$routinePositon]);
    }

    static function isAllDone(): bool
    {
        return empty(self::$routines);
    }

    static function Run(): void
    {
        while(!self::isAllDone()) self::ResolveAll();
    }

    static function ClearIfDone(State $state, int $position): void
    {
        if($state == State::Done ) self::Remove($position);
    }
}
