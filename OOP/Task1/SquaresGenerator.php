<?php
declare(strict_types=1);

namespace OOP\Task1;

require 'Square.php';

/**
 * Class SquaresGenerator
 *
 * @package OOP\Task1
 */
class SquaresGenerator
{

    /**
     * @param float $side
     * @param int   $count Сторона квадрата
     *
     * @return array Массив экземпляров
     */
    public static function generate(float $side, int $count)
    {

        $result = [];

        while ($count) {
            $result[] = new Square($side);
            $count--;
        }

        return $result;
    }
}


var_dump($squares = SquaresGenerator::generate(3, 2));

foreach ($squares as $square) {
    var_dump($square->getSide());
}