<?php
declare(strict_types=1);

namespace Helper;

class Registry
{
    private static ?Registry $instance = null;
    private array $items = [];

    private function __construct()
    {
    }

    public static function getInstance(): static
    {
        if (!self::$instance)
            self::$instance = new static();
        return self::$instance;
    }

    public function add($field, $value)
    {
        $this->items[$field] = $value;
        return $this->items[$field];
    }

    public function get($field)
    {
        return $this->items[$field];
    }
}