<?php

/**
 * D — Dependency Inversion
 * Завдання: сервіс напряму створює конкретний репозиторій. Інвертуй залежність: залеж від інтерфейсу,
 * інʼєктуй реалізацію (можна підкласти InMemory для тестів).
 *
 * Є інтерфейс OrderRepository.
 * OrderService отримує його через конструктор.
 * Легко підмінити на InMemoryOrderRepository у тестах без зміни OrderService.
 */

class MySqlOrderRepository
{
    public function save(array $order): void
    {
        // умовна робота з БД
        echo "Saved order #{$order['id']} to MySQL\n";
    }
}

class OrderService
{
    private MySqlOrderRepository $repo;

    public function __construct()
    {
        $this->repo = new MySqlOrderRepository(); // жорстке зчеплення
    }

    public function place(array $order): void
    {
        $this->repo->save($order);
    }
}

$svc = new OrderService();
$svc->place(['id' => 101]);
