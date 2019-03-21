<?php
declare(strict_types=1);

namespace OOP\Task1;

use mysql_xdevapi\Exception;

require 'Square.php';

/**
 * Class SquaresGenerator Позволяет генерировать квадраты
 *
 * @package OOP\Task1
 */
class SquaresGenerator
{

    /**
     * Метод позволяет генерировать заданное количество квадратов с заданной стороной
     *
     * @param float $side  Размер стороны квадратов
     * @param int   $count Количество генерируемых квадратов
     *
     * @return array Массив квадратов
     */
    public static function generate(float $side, int $count): array
    {

        if ($count < 0) {
            throw new Exception('Количество генерируемых квадратов меньше нуля');
        }

        $result = [];

        while ($count--) {
            $result[] = new Square($side);
        }

        return $result;
    }
}


var_dump($squares = SquaresGenerator::generate(3, 2));

foreach ($squares as $square) {
    var_dump($square->getSide());
}