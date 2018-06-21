<?php
declare(strict_types=1);

namespace ExampleApp;

class HelloWorld
{
    public function __invoke(): void
    {
        echo 'Hello, autoloaded world!';
        exit;
    }
}