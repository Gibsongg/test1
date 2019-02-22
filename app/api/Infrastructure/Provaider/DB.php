<?php
declare(strict_types=1);

namespace Infrastructure\Provaider;
//TODO: Сделать рефакторинг названия диреткории и неймспейсов
class DB
{
    private static $instance = null;

    public static function getInstance(): \PDO
    {
        //TODO: можно вынести в конфиг
        if (static::$instance === null) {
            static::$instance = new \PDO('sqlite:' . dirname($_SERVER['DOCUMENT_ROOT']) . '/data/structure.db');
        }

        return static::$instance;
    }

    private function __construct()
    {
    }

    private function __wakeup()
    {
    }

    private function __clone()
    {
    }

}