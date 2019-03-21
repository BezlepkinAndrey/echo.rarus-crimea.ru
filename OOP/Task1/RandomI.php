<?php
declare(strict_types=1);

namespace OOP\Task1;

/**
 * Interface RandomInterface Интерфейс генератора случайных чисел. Может применяться совместно с стандартными
 * генераторами случайных чисел
 *
 * @package OOP\Task1
 */
interface RandomInterface
{
    /**
     * RandomInterface конструктор.
     *
     * @param int $seed Начальное псевдослучайное число
     */
    function __construct(int $seed);

    /**
     * Метод позволяет получить случайное число
     *
     * @return int Случайное число
     */
    function getNext(): int;

    /**
     * Сброс генератора до первоначального состояния
     *
     * @return mixed
     */
    function reset();
}