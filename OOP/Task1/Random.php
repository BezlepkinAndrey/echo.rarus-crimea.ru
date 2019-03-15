<?php


namespace OOP\Task1;

interface RandomInterface
{
    function __construct($seed);

    function getNext();

    function reset();
}

/**
 * Class Random
 *
 * @package OOP\Task1
 */
class Random implements RandomInterface
{

    protected $seed;
    protected $a;
    protected $c;
    protected $m;

    protected $previousState = 0;

    /**
     * Random constructor.
     *
     * @param $seed Первое рандомное значение
     */
    public function __construct($seed)
    {
        $this->seed = $seed;
        $this->previousState = $seed;
        $this->a = 1103515245;
        $this->c = 12345;
        $this->m = pow(2, 31);
    }

    /**
     * @return int Псевда рандомное число
     */
    function getNext()
    {
        return $this->previousState = ($this->a * $this->previousState + $this->c) % $this->m;
    }

    /**
     * Сброс генератора псевдослучайных часел
     */
    function reset()
    {
        $this->previousState = $this->seed;
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
