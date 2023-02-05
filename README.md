# Corotina em PHP
Este estudo foi feito com o intuito de entender como Corotinas são feitas em single-thread, sem uso de ferramentas externas ou extenções do php, apenas com PHP puro.

### As classes Coroutines e Task
A classe `Coroutines`, manipula as *Tasks*. Ele gerencia quando executar, verifica se ela está terminada para que, então, seja removida a `Task` da lista de tarefas.

## Códigos de exemplo

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
    
    echo "(3) ... mais do que ..." . PHP_EOL;
    yield;
    
    echo "(3) ... duas interações!!!" . PHP_EOL;
    yield;
});
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

## Execução em máquina
Para a execução do código em utilizar o comando setado no composer ou usar rodar com o php diretamento. Os códigos de exemplos ficam na pasta examples.

#### Composer
```Bash
$: composer run dev
```

#### PHp
```Bash
$: php examples/coroutine.php
```