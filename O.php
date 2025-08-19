<?php

/**
 * O — Open/Closed
 * Завдання: не змінюючи логіку центрального калькулятора, додай новий тип знижки black_friday (−50%). Перероби на політики/стратегії.
 *
 * Є інтерфейс на кшталт DiscountPolicy.
 * Політики реєструються/інʼєктуються, а не хардкодяться в switch.
 * Додавання black_friday не потребує змін у DiscountCalculator.
 */

// class DiscountCalculator
// {
//     public function calc(string $type, float $price): float
//     {
//         switch ($type) {
//             case 'regular': return $price;
//             case 'vip':     return $price * 0.9;
//             default:
//                 throw new InvalidArgumentException("Unknown type: $type");
//         }
//     }
// }

// $calc = new DiscountCalculator();
// echo $calc->calc('vip', 100.0); // 90



interface DiscountStrategy{
    public function supports(string $type): bool;
    public function calculate(float $price): float;
}




class RegularDiscount implements DiscountStrategy{
    public function supports(string $type): bool
    {
        return $type === 'regular';
    }

   public function calculate($price): float
   {
    return $price;
   }
}

class VipDiscount implements DiscountStrategy{
    public function supports(string $type): bool
    {
        return $type === 'vip';
    }

   public function calculate($price): float
   {
    return  $price * 0.9;
   }
}

class BlackFridayDiscount implements DiscountStrategy{
    public function supports(string $type): bool
    {
        return $type === 'black_friday';
    }

   public function calculate($price): float
   {
    return  $price * 0.5;
   }
}

class DiscountCalculator
{
    private array $strategies;

    public function __construct(DiscountStrategy ...$strategies){
        {
            $this->strategies = $strategies;
        }
    }
    public function calc(string $type, float $price): float
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($type)) {
                return $strategy->calculate($price);
            }
        }
        
        throw new InvalidArgumentException("Unknown discount type: $type");
    }
}


$strategies = [
    new RegularDiscount(),
    new VipDiscount(),
    new BlackFridayDiscount()
];


$calculator = new DiscountCalculator(...$strategies);


echo $calculator->calc('vip', 100); // 90
echo $calculator->calc('black_friday', 100); // 50