# Corotina em PHP
Este estudo foi feito com o intuito de entender como Corotinas são feitas em single-thread, sem uso de ferramentas externas ou extenções do php, apenas com PHP puro.

### As classes Coroutines e Task
A classe `Coroutines`, manipula as *Tasks*. Ele gerencia quando executar, verifica se ela está terminada para que, então, seja removida a `Task` da lista de tarefas.

## Códigos de exemplo

#### Basic usage:
```PHP
<?php
// ... 
Coroutines::Add(function () {
    echo "(1) First execution ..." . PHP_EOL;
    yield;

    echo "(1) ... of a generator!!!" . PHP_EOL;
    yield;
});

Coroutines::Add(function () {
    echo "(2) It's another ..." . PHP_EOL;
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
```

*Output:*
```
(1) First execution ...
(2) It is another ...
(3) Qualquer coisa ...
(1) ...of a generator!!
(2) ... generator!!!!
(3) ... para que tenha ...
(3) ... mais do que...
(3) ... duas iterações!!!'
```

#### Awaiting subcoroutine
```php
// ...
Coroutines::Add(function () {
    echo "(1) First execution ..." . PHP_EOL;
    yield from Coroutines::Sleep(3);
    
    echo "(1) ... of a generator!!" . PHP_EOL;
    yield;
});

Coroutines::Add(function () {
    echo "(2) It is another ..." . PHP_EOL;
    yield from Coroutines::Sleep(1);

    echo "(2) ... generator!!!!" . PHP_EOL;
    yield;
});

Coroutines::Add(function () {
    echo "(3) Anything ..." . PHP_EOL;
    yield from Coroutines::Sleep(1);

    echo "(3) ... to have ..." . PHP_EOL;
    yield;
    
    echo "(3) ... more than ..." . PHP_EOL;
    yield from Coroutines::Sleep(2);
    
    echo "(3) ... two interactions!!!" . PHP_EOL;
    yield;
});

Coroutines::Run();
```

*Output:*
```
(1) First execution ...
(2) It is another ...
(3) Anything ...
(3) ... to have ...
(3) ... more than ...
(2) ... generator!!!!
(1) ... of a generator!!
(3) ... two interactions!!!
```

## Execução em máquina
Para a execução do código em utilizar o comando setado no composer ou usar rodar com o php diretamento. Os códigos de exemplos ficam na pasta examples.

#### PHP
```Bash
$: php examples/coroutine.php
```

## Versão do PHP
Foi desenvolvido em cima do PHP 8.1.2 mas os `Generators` - que é a base do projeto - existem desde o PHP 5.5.0.

Para ver o tempo de execução utilize o comando `time` no terminal linux antes de rodar o php.