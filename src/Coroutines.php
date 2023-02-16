<?php

namespace Lipe\PhpCoroutine;

use Generator;

class Coroutines
{
    private static array $tasks = [];

    public static function Add(callable $newTask, mixed $params = null): void
    {
        $task = new Task($newTask, $params);

        array_push(self::$tasks, $task);
    }

    public static function ResolveAll(): void
    {
        foreach(self::$tasks as $i => $task) {
            $task->resolve()->next();
            if($task->isDone()) unset(self::$tasks[$i]);
        }
    }

    private static function isAllDone(): bool
    {
        return empty(self::$tasks);
    }

    public static function Run(): void
    {
        while(!self::isAllDone()) {
            self::ResolveAll();
        }
    }

    public static function Sleep(int $second): Generator
    {
        $deadline = time() + $second;
        while(time() <= $deadline) {
            yield State::Paused;
        }
    }
}
