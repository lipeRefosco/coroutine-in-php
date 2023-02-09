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
        $task = array_shift(self::$tasks);
        $task->resolve()->next();

        if($task->isRunning()) self::$tasks[] = $task;
        if($task->isPaused()) self::$tasks[] = $task;
        if($task->isDone()) return;
    }

    private static function isAllDone(): bool
    {
        return empty(self::$tasks);
    }

    public static function Run(): void
    {
        while(!self::isAllDone()) self::ResolveAll();
    }

    public static function Sleep(int $second): Generator
    {
        $deadline = time() + $second;
        while(time() <= $deadline) {
            yield State::Paused;
        }
    }
}
