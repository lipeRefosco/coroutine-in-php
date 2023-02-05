<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Lipe\PhpCoroutine\Coroutines;

Coroutines::Add(function () {
    echo "(1) First execution ..." . PHP_EOL;
    yield;

    echo "(1) ...of a generator!!" . PHP_EOL;
    yield;
});

Coroutines::Add(function () {
    echo "(2) It is another ..." . PHP_EOL;
    yield;

    echo "(2) ... generator!!!!" . PHP_EOL;
    yield;
});

Coroutines::Add(function () {
    echo "(3) Qualquer coisa ..." . PHP_EOL;
    yield;

    echo "(3) ... para que tenha ..." . PHP_EOL;
    yield;
    
    echo "(3) ... mais do que..." . PHP_EOL;
    yield;
    
    echo "(3) ... duas interações!!!" . PHP_EOL;
    yield;
});

Coroutines::Run();