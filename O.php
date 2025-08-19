<?php

/**
 * O — Open/Closed
 * Завдання: не змінюючи логіку центрального калькулятора, додай новий тип знижки black_friday (−50%). Перероби на політики/стратегії.
 *
 * Є інтерфейс на кшталт DiscountPolicy.
 * Політики реєструються/інʼєктуються, а не хардкодяться в switch.
 * Додавання black_friday не потребує змін у DiscountCalculator.
 */

class DiscountCalculator
{
    public function calc(string $type, float $price): float
    {
        switch ($type) {
            case 'regular': return $price;
            case 'vip':     return $price * 0.9;
            default:
                throw new InvalidArgumentException("Unknown type: $type");
        }
    }
}

$calc = new DiscountCalculator();
echo $calc->calc('vip', 100.0); // 90
