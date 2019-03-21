<?php

declare(strict_types=1);

namespace OOP\Task1;

/**
 * Class Square Описывает квадрат
 *
 * @package OOP\Task1
 */
class Square
{

    protected $side;

    /**
     * Square конструктор.
     *
     * @param float $side Сторона квадрата
     */
    public function __construct(float $side)
    {

        if ($side < 0) {
            throw new Exception("Сторона квадрата < 0");
        }

        $this->side = $side;
    }

    /**
     * Метод позволяющий получить сторону квадрата
     *
     * @return float Сторона квадрата
     */
    public function getSide(): float
    {
        return $this->side;
    }

}

