<?php

declare(strict_types=1);

namespace OOP\Task1;

require 'RandomI.php';

/**
 * Class Random Является генератором псевдаслучайных чисел. Реализует алгоритм - https://ru.wikipedia.org/wiki/Линейный_конгруэнтный_метод
 * Параметры алгоритма как в генераторах - ANSI C: Watcom, Digital Mars, CodeWarrior, IBM VisualAge C/C++
 *
 * @package OOP\Task1
 */
class Random implements RandomInterface
{

    protected $seed;
    protected $a;
    protected $c;
    protected $m;

    protected $currentValue = 0;

    /**
     * Random конструктор.
     *
     * @param int $seed Начальное псевдослучайное число
     */
    public function __construct(int $seed)
    {
        $this->seed = $seed;
        $this->currentValue = $seed;
        $this->a = 1103515245;
        $this->c = 12345;
        $this->m = pow(2, 31);
    }

    /**
     * Метод позволяет получить случайное число
     *
     * @return int Случайное число
     */
    function getNext(): int
    {
        return $this->currentValue = ($this->a * $this->currentValue + $this->c) % $this->m;
    }

    /**
     * Сброс генератора до первоначального состояния
     *
     * @return mixed
     */
    function reset()
    {
        $this->currentValue = $this->seed;
    }
}

$seq = new Random(100);
$result1 = $seq->getNext();
$result2 = $seq->getNext();

var_dump($result1 != $result2);

$seq->reset();

$result21 = $seq->getNext();
$result22 = $seq->getNext();

var_dump($result1 == $result21); // => true
var_dump($result2 == $result22); // => true
