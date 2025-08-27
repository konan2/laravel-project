<?php

/**
 * L — Liskov Substitution
 *
 * Завдання:
 * нижня ієрархія ламає підстановку (LSP).
 * Перероби дизайн так, щоб неможливо було передати «квадрат» туди, де очікують «прямокутник»,
 * або щоб клієнтський код працював через абстракцію, яка не порушує LSP.
 *
 *
 * Прибрати успадкування Square extends Rectangle; ввести інтерфейс (наприклад, ResizableShape) і приймати його в клієнті.
 * Або ізолювати «квадрат» іншим API, щоб він не підміняв «прямокутник».
 * Після рефакторингу немає ситуації, де об’єкт із «стриманішим» контрактом порушує очікування клієнта.
 */

// class Rectangle
// {
//     public function __construct(protected int $w, protected int $h) {}
//     public function setWidth(int $w): void  { $this->w = $w; }
//     public function setHeight(int $h): void { $this->h = $h; }
//     public function area(): int { return $this->w * $this->h; }
// }

// class Square extends Rectangle
// {
//     public function __construct(int $size) { parent::__construct($size, $size); }
//     public function setWidth(int $w): void  { parent::setWidth($w);  parent::setHeight($w); }
//     public function setHeight(int $h): void { parent::setHeight($h); parent::setWidth($h); }
// }

// function resizeTo4x5(Rectangle $r): void
// {
//     $r->setWidth(4);
//     $r->setHeight(5);
// }

// $r1 = new Rectangle(1, 1);
// resizeTo4x5($r1);
// assert($r1->area() === 20); // ✅

// $r2 = new Square(1);
// resizeTo4x5($r2);
// assert($r2->area() === 20); // ❌ порушення LSP (отримуємо 25)


////////////////

interface Shape {
    public function getArea(): int;
}

interface ResizableShape extends Shape {
    public function setWidth(int $width): void;
    public function setHeight(int $height): void;
    public function setSize(int $size): void;
}

abstract class AbstractShape implements Shape {
    public $width;
    public $height;
    
    public function __construct($width, $height) {
        $this->width = $width;
        $this->height = $height;
    }
    
    public function getArea(): int {
        return $this->width * $this->height;
    }
}

class Square extends AbstractShape implements ResizableShape {
    public function __construct($size) {
        parent::__construct($size, $size);
    }
    
    public function setSize(int $size): void {
        $this->width = $size;
        $this->height = $size;
    }
    
    public function setWidth(int $width): void {
        $this->setSize($width);
    }
    
    public function setHeight(int $height): void {
        $this->setSize($height);
    }
}

class Rectangle extends AbstractShape implements ResizableShape {
    public function __construct($width, $height) {
        parent::__construct($width, $height);
    }
    
    public function setWidth(int $width): void {
        $this->width = $width;
    }
    
    public function setHeight(int $height): void {
        $this->height = $height;
    }
    
    public function setSize(int $size): void {
        $this->width = $size;
        $this->height = $size;
    }
}

function resizeShape(ResizableShape $shape): void {
    if ($shape instanceof Rectangle) {
        $shape->setWidth(4);
        $shape->setHeight(5);
    } elseif ($shape instanceof Square) {
        $shape->setSize(4); 
    }
}