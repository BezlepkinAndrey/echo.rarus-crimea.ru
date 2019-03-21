<?php

declare(strict_types=1);

namespace OOP\Task1;

require 'UrlI.php';

/**
 * Class Url Реализует интерфейс UrlInterface, предоставляющий методы по получению элементов запроса
 *
 * @package OOP\Task1
 */
class Url implements UrlInterface
{

    protected $url;
    protected $host;
    protected $scheme;
    protected $queryParams;

    /**
     * Url конструктор
     *
     * @param string $url Url с которым будетут производиться манипуляции
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Метод позволяет получить схему запроса
     *
     * @param string $url Url из которого нужно получить схему
     *
     * @return string Схема
     */
    public static function scheme(string $url): string
    {
        return parse_url($url)['scheme'];
    }

    /**
     * Метод позволяет получить хост запроса
     *
     * @param string $url Url из которого нужно получить хост
     *
     * @return string Хост
     */
    public static function host(string $url): string
    {
        return parse_url($url)['host'];
    }

    /**
     * Метод позволяет получить параметры запроса в ассоциативном массиве
     *
     * @param string $url Url из которого нужно получить параметры
     *
     * @return array Параметры запроса
     */
    public static function queryParams(string $url): array
    {
        $parts = parse_url($url);
        $queryParams = [];
        parse_str($parts['query'], $queryParams);
        return $queryParams;
    }

    /**
     * Метод позволяет получить схему URL запроса
     *
     * @return string Схема URL запроса
     */
    public function getScheme(): string
    {
        if (isset($this->scheme)) {

            return $this->scheme;
        } else {

            return $this->scheme = $this->scheme($this->url);
        }
    }

    /**
     * Метод позволяет получить хост URL запроса
     *
     * @return string Хост URL запроса
     */
    public function getHost(): string
    {
        if (isset($this->host)) {

            return $this->host;
        } else {

            return $this->host = $this->host($this->url);
        }
    }

    /**
     * Метод позволяет получить массив параметров URL запроса
     *
     * @return array Массив параметров запроса
     */
    public function getQueryParams(): array
    {
        if (isset($this->queryParams)) {

            return $this->queryParams;
        } else {

            return $this->queryParams = $this->queryParams($this->url);
        }
    }

    /**
     * Метод позволяет получить параметр URL запроса или если его нет вернуть дефолтное значение
     *
     * @param string      $key          Наименование параметра
     * @param string|null $defaultValue Дефолтное значение возвращаемое в случае отсутствия параметра
     *
     * @return string|null
     */
    public function getQueryParam(string $key, ?string $defaultValue = null): ?string
    {
        $params = $this->getQueryParams();
        return isset($params[$key]) ? $params[$key] : $defaultValue;
    }

}

$url = new Url('http://yandex.ru?key=value&key2=value2');
var_dump($url->getScheme()); // http
var_dump($url->getHost()); // yandex.ru
var_dump($url->getQueryParams());
// [
//     'key' => 'value',
//     'key2' => 'value2'
// ];
var_dump($url->getQueryParam('key')); // value
// второй параметр - значение по умолчанию
var_dump($url->getQueryParam('key2', 'lala')); // value2
var_dump($url->getQueryParam('new', 'ehu')); // ehu
