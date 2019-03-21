<?php

declare(strict_types=1);

namespace OOP\Task1;

/**
 * Interface UrlInterface
 *
 * @package OOP\Task1
 */
interface UrlInterface
{
    public function getScheme();

    public function getHost();

    public function getQueryParams();

    public function getQueryParam(string $key, $defaultValue);

}

/**
 * Class Url
 *
 * @package OOP\Task1
 */
class Url implements UrlInterface
{

    protected $url;

    /**
     * Url constructor.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed URL Схема
     */
    public function getScheme()
    {
        return parse_url($this->url)['scheme'];
    }

    /**
     * @return mixed URL Хост
     */
    public function getHost()
    {
        return parse_url($this->url)['host'];
    }

    /**
     * @return array Параметра запроса
     */
    public function getQueryParams()
    {
        $parts = parse_url($this->url);
        $query = [];
        parse_str($parts['query'], $query);
        print_r($query);
        return $query;
    }

    /**
     * @param string $key          Ключ по которому будет происходить поиск
     * @param null   $defaultValue Значение возвращающееся по умолчанию
     *
     * @return mixed|null
     */
    public function getQueryParam(string $key, $defaultValue = null)
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
