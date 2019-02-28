<?php

const FREE_EMAIL_DOMAINS = ['gmail.com', 'yandex.ru', 'hotmail.com'];

function getFreeDomainsCount($emails)
{
    $allHosts = array_map(function ($item) {
        return preg_replace('/[^@]{0,}@/', '', $item);
    }, $emails);

    $hosts = array_intersect($allHosts, FREE_EMAIL_DOMAINS);

    return array_count_values($hosts);
}

$emails = [
    'info@gmail.com',
    'info@yandex.ru',
    'info@hotmail.com',
    'mk@host.com',
    'support@bitrix.com',
    'keys@yandex.ru',
    'sergey@gmail.com',
    'vovan@gmail.com',
    'vovan@hotmail.com'
];

print_r(getFreeDomainsCount($emails));
# => Array (
#     'gmail.com' => 3
#     'yandex.ru' => 2
#     'hotmail.com' => 2
#  )