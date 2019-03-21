<?php


declare(strict_types=1);

namespace OOP\Task1;

/**
 * Интерфейс работы с составными частями URL. Применяется при парсинге запросов
 *
 * @package OOP\Task1
 */
interface UrlInterface
{
    /**
     * Метод позволяет получить схему URL запроса
     *
     * @return string Схема URL запроса
     */
    public function getScheme(): string;

    /**
     * Метод позволяет получить хост URL запроса
     *
     * @return string Хост URL запроса
     */
    public function getHost(): string;

    /**
     * Метод позволяет получить массив параметров URL запроса
     *
     * @return array Массив параметров запроса
     */
    public function getQueryParams(): array;

    /**
     * Метод позволяет получить параметр URL запроса или если его нет вернуть дефолтное значение
     *
     * @param string      $key          Наименование параметра
     * @param string|null $defaultValue Дефолтное значение возвращаемое в случае отсутствия параметра
     *
     * @return string|null
     */
    public function getQueryParam(string $key, ?string $defaultValue): ?string;

}