<?php

/**
 * I — Interface Segregation
 * Завдання: розділи «товстий» інтерфейс на дрібніші, щоб клієнти не імплементували зайвого.
 *
 * Інтерфейси розділені (наприклад, Printable, Scannable, Faxable).
 * SimplePrinter імплементує лише Printable.
 * Клієнти залежать рівно від тих контрактів, які їм потрібні.
 */

// interface MultiFunctionDevice
// {
//     public function print(string $doc): void;
//     public function scan(): string;
//     public function fax(string $doc, string $number): void;
// }

// class SimplePrinter implements MultiFunctionDevice
// {
//     public function print(string $doc): void { echo "Printing: $doc\n"; }
//     public function scan(): string          { throw new \LogicException('Not supported'); }
//     public function fax(string $doc, string $number): void { throw new \LogicException('Not supported'); }
// }




interface Printable
{
    public function print(string $doc): void;
}

interface Scannable
{
    public function scan(): string;
}

interface Faxable
{
    public function fax(string $doc, string $number): void;
}


class SimplePrinter implements Printable
{
    public function print(string $doc): void
    {
        echo "Printing: $doc\n";
    }
}


class MultiFunctionDevice implements Printable, Scannable, Faxable
{
    public function print(string $doc): void
    {
        echo "Printing: $doc\n";
    }
    
    public function scan(): string
    {
        return "Scanned document content";
    }
    
    public function fax(string $doc, string $number): void
    {
        echo "Faxing '$doc' to $number\n";
    }
}


class Scanner implements Scannable
{
    public function scan(): string
    {
        return "Scanned document content";
    }
}


class PrinterScanner implements Printable, Scannable
{
    public function print(string $doc): void
    {
        echo "Printing: $doc\n";
    }
    
    public function scan(): string
    {
        return "Scanned document content";
    }
}


$simplePrinter = new SimplePrinter();
$simplePrinter->print("Test document"); 

$multiDevice = new MultiFunctionDevice();
$multiDevice->print("Report");
$multiDevice->fax("Contract", "+123456789");
echo $multiDevice->scan();

$scanner = new Scanner();
echo $scanner->scan();