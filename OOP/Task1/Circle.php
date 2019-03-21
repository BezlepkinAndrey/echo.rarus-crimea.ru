<?php

declare(strict_types=1);

namespace OOP\Task1;

/**
 * Class Circle Позволяет описать круг, может применяться при расчетах параметров круга
 *
 * @package OOP\Task1
 */
class Circle
{
    protected $radius;
    protected $area;
    protected $circumference;

    /**
     * Circle конструктор.
     *
     * @param float $radius Радиус круга
     */
    public function __construct(float $radius)
    {
        if ($radius <= 0) {
            throw new Exception('Радиус <= 0');
        }

        $this->radius = $radius;
        $this->area = $this->area($radius);
        $this->circumference = $this->area($radius);
    }

    /**
     * Метод позволяет получить площадь круга
     *
     * @param float $radius Радиус круга для расчета
     *
     * @return float Площадь круга
     */
    public static function area(float $radius): float
    {
        return pi() * ($radius * $radius);
    }

    /**
     * Метод позволяет найти длину окружности по тереданному
     *
     * @param float $radius Радиус круга для расчета
     *
     * @return float Длина окружности
     */
    public static function circumference(float $radius): float
    {
        return 2 * pi() * $radius;
    }

    /**
     * Позволяет получить длину окружности объекта
     *
     * @return float Длина окружности
     */
    public function getCircumference(): float
    {
        if (isset($this->circumference)) {

            return $this->circumference;
        } else {

            return $this->circumference = $this->circumference($this->radius);
        }
    }

    /**
     * Позволяет получить площадь круга (объекта)
     *
     * @return float Длина окружности
     */
    public function getArea(): float
    {
        if (isset($this->area)) {

            return $this->area;
        } else {

            return $this->area = $this->area($this->radius);
        }
    }

}

$circle = new Circle(10);
echo 'Длина ' . $circle->getCircumference();
echo 'Площадь ' . $circle->getArea();
