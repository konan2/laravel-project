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

class Rectangle
{
    public function __construct(protected int $w, protected int $h) {}
    public function setWidth(int $w): void  { $this->w = $w; }
    public function setHeight(int $h): void { $this->h = $h; }
    public function area(): int { return $this->w * $this->h; }
}

class Square extends Rectangle
{
    public function __construct(int $size) { parent::__construct($size, $size); }
    public function setWidth(int $w): void  { parent::setWidth($w);  parent::setHeight($w); }
    public function setHeight(int $h): void { parent::setHeight($h); parent::setWidth($h); }
}

function resizeTo4x5(Rectangle $r): void
{
    $r->setWidth(4);
    $r->setHeight(5);
}

$r1 = new Rectangle(1, 1);
resizeTo4x5($r1);
assert($r1->area() === 20); // ✅

$r2 = new Square(1);
resizeTo4x5($r2);
assert($r2->area() === 20); // ❌ порушення LSP (отримуємо 25)
