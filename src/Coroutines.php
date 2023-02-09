<?php

namespace Lipe\PhpCoroutine;

use Generator;

class Coroutines
{
    static private array $tasks;


    public static function Add(callable $newTask, mixed ...$params): void
    {
        self::$tasks[] = new Task($newTask, $params);
    }

    public static function ResolveAll(): void
    {
        foreach (self::$tasks as $position => $task) {
            $task->resolve();
            self::ClearIfDone($task->state(), $position);
        }
    }

    private static function Remove($taskPosition): void
    {
        unset(self::$tasks[$taskPosition]);
    }

    private static function isAllDone(): bool
    {
        return empty(self::$tasks);
    }

    public static function Run(): void
    {
        while(!self::isAllDone()) self::ResolveAll();
    }

    private static function ClearIfDone(State $state, int $position): void
    {
        if($state == State::Done ) self::Remove($position);
    }

    public static function Sleep(int $second): Generator
    {
        $deadline = time() + $second;
        while(time() <= $deadline) {
            yield State::Paused;
        }
    }
}
