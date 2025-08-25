<?php


class Order{
    public readonly string $id;
    public readonly bool $paid;
    public array $observers = [];

    public function __construct(){
        $this->id = uniqid();
        $this->paid = false;
    }
    public function pay(): void{
        $this->paid = true;
        $this->notify();
    }
    public function notify():void{
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
    public function attach(Observer $observer) : void{
        $this->observers[] = $observer;
    }
    public function detach(Observer $observer) : void{
        $this->observers = array_filter($this->observers, function($o) use ($observer){
            return $o !== $observer;
        });
    }
}

interface ObserverInterface{
    public function update(Order $order): void;
}

class EmailNotifier implements ObserverInterface{
    public function update(Order $order): void{
        echo "Sending email for order {$order->id}\n";
    }
}

class AuditLogger implements ObserverInterface{
    public function update(Order $order): void{
        echo "Logging order {$order->id} to audit log\n";
    }
}

$order = new Order();
$order->attach(new EmailNotifier());
$order->attach(new AuditLogger());
$order->pay();
