<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Lipe\PhpCoroutine\Coroutines;

Coroutines::Add(function () {
    echo "(1) First execution ..." . PHP_EOL;
    yield;
    
    echo "(1) ... of a generator!!" . PHP_EOL;
    yield;
});

Coroutines::Add(function () {
    echo "(2) It is another ..." . PHP_EOL;
    yield;

    echo "(2) ... generator!!!!" . PHP_EOL;
    yield;
});

Coroutines::Add(function () {
    echo "(3) Anything ..." . PHP_EOL;
    yield;

    echo "(3) ... to have ..." . PHP_EOL;
    yield;
    
    echo "(3) ... more than ..." . PHP_EOL;
    yield;
    
    echo "(3) ... two interactions!!!" . PHP_EOL;
    yield;
});

Coroutines::Run();