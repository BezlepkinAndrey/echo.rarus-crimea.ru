<?php

namespace Number;

function reverse($num)
{
    $minus = $num < 0;
    $num = abs($num);
    $num = (int)strrev('' . $num);
    return $num * (($minus) ? -1 : 1);

}
