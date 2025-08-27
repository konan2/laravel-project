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

// class MySqlOrderRepository
// {
//     public function save(array $order): void
//     {
//         // умовна робота з БД
//         echo "Saved order #{$order['id']} to MySQL\n";
//     }
// }

// class OrderService
// {
//     private MySqlOrderRepository $repo;

//     public function __construct()
//     {
//         $this->repo = new MySqlOrderRepository(); // жорстке зчеплення
//     }

//     public function place(array $order): void
//     {
//         $this->repo->save($order);
//     }
// }

// $svc = new OrderService();
// $svc->place(['id' => 101]);





// abstraction
interface OrderRepository
{
    public function save(array $order): void;
}


class MySqlOrderRepository implements OrderRepository
{
    public function save(array $order): void
    {
       
        echo "Saved order #{$order['id']} to MySQL\n";
    }
}



class OrderService
{
    private OrderRepository $repo;

    // Dependency Injection via constructor
    public function __construct(OrderRepository $repo)
    {
        $this->repo = $repo;
    }

    public function place(array $order): void
    {
        $this->repo->save($order);
    }
}



// testing
class InMemoryOrderRepository implements OrderRepository
{
    private array $orders = [];
    
    public function save(array $order): void
    {
        $this->orders[] = $order;
        echo "Saved order #{$order['id']} to memory. Total orders: " . count($this->orders) . "\n";
    }
    
    public function getOrders(): array
    {
        return $this->orders;
    }
}



$mysqlRepo = new MySqlOrderRepository();
$productionService = new OrderService($mysqlRepo);
$productionService->place(['id' => 101]);

// test
$memoryRepo = new InMemoryOrderRepository();
$testService = new OrderService($memoryRepo);
$testService->place(['id' => 201]);
$testService->place(['id' => 202]);

