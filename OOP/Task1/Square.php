<?php


namespace OOP\Task1;

/**
 * Class Square
 *
 * @package OOP\Task1
 */
class Square
{

    protected $side;

    /**
     * Square constructor.
     *
     * @param $side Сторона квадрата
     */
    public function __construct($side)
    {
        $this->side = $side;
    }

    /**
     * @return \OOP\Task1\Сторона Сторона квадрата
     */
    public function getSide()
    {
        return $this->side;
    }

}

