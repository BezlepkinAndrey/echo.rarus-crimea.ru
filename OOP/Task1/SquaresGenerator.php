<?php

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
     * @param $side  Сторона квадрата
     * @param $count Количество экземпляров
     *
     * @return array Массив экземпляров
     */
    public static function generate($side, $count)
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