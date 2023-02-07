<?php

namespace Lipe\PhpCoroutine;

enum State {
    case Startup;
    case Running;
    case Paused;
    case Done;
}