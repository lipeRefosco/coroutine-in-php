<?php

namespace Lipe\PhpCoroutine;

class Coroutines
{
    static private array $tasks;


    static function Add(callable $newTask, mixed ...$params): void
    {
        self::$tasks[] = new Task($newTask, $params);
    }

    static function ResolveAll(): void
    {
        foreach (self::$tasks as $position => $task) {
            $task->resolve();
            self::ClearIfDone($task->state(), $position);
        }
    }

    static function Remove($taskPosition): void
    {
        unset(self::$tasks[$taskPosition]);
    }

    static function isAllDone(): bool
    {
        return empty(self::$tasks);
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
