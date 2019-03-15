<?php

namespace OOP\Task1;

/**
 * Class Circle
 *
 * @package OOP\Task1
 */
class Circle
{
    protected $radius = 0;

    /**
     * Circle constructor.
     *
     * @param $radius Радиус круга
     */
    public function __construct($radius)
    {
        $this->radius = $radius;
    }

    /**
     * @return float|int Длина окружности
     */
    public function getCircumference()
    {
        return 2 * pi() * $this->radius;
    }

    /**
     * @return float|int Площадь вигуры
     */
    public function getArea()
    {
        return pi() * ($this->radius * $this->radius);
    }

}

$circle = new Circle(10);
echo 'Длина ' . $circle->getCircumference();
echo 'Площадь ' . $circle->getArea();
