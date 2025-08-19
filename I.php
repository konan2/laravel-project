<?php

/**
 * I — Interface Segregation
 * Завдання: розділи «товстий» інтерфейс на дрібніші, щоб клієнти не імплементували зайвого.
 *
 * Інтерфейси розділені (наприклад, Printable, Scannable, Faxable).
 * SimplePrinter імплементує лише Printable.
 * Клієнти залежать рівно від тих контрактів, які їм потрібні.
 */

interface MultiFunctionDevice
{
    public function print(string $doc): void;
    public function scan(): string;
    public function fax(string $doc, string $number): void;
}

class SimplePrinter implements MultiFunctionDevice
{
    public function print(string $doc): void { echo "Printing: $doc\n"; }
    public function scan(): string          { throw new \LogicException('Not supported'); }
    public function fax(string $doc, string $number): void { throw new \LogicException('Not supported'); }
}
