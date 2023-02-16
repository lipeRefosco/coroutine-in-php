<?php

namespace Lipe\PhpCoroutine;

use Generator;

class Coroutines
{
    private static array $tasks = [
        "startup" => [],
        "running" => [],
        "paused"  => [],
        "done"    => []
    ];

    public static function Add(callable $newTask, mixed $params = null): void
    {
        $task = new Task($newTask, $params);

        array_push(self::$tasks["startup"], $task);
    }

    public static function ResolveAll(string $state): void
    {
        if(self::isAllDone($state)) return;

        $task = array_shift(self::$tasks[$state]);

        $task->resolve()->next();

        self::Switch($task);
    }

    private static function Switch (Task $task): void
    {
        if($task->isRunning()) array_push(self::$tasks["running"], $task);
        if($task->isPaused()) array_push(self::$tasks["paused"], $task);
        if($task->isDone()) array_push(self::$tasks["done"], $task);
    }

    public static function ClearAll(string $state): void
    {
        array_shift(self::$tasks[$state]);
    }

    private static function isAllDone(string $state): bool
    {
        return empty(self::$tasks[$state]);
    }

    public static function Run(): void
    {
        while(
            !self::isAllDone("startup") ||
            !self::isAllDone("running") ||
            !self::isAllDone("paused")
        ) {
            self::ResolveAll("startup");
            self::ResolveAll("running");
            self::ResolveAll("paused");
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
