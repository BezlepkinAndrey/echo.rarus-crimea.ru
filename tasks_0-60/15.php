<?php

function makeCensored($str, $args)
{
    return implode(' ', array_map(function ($item) use ($args) {
        return (in_array($item, $args) ? '$#%!' : $item);
    }, explode(' ', $str)));
}

$sentence = 'When you play the game of thrones, you win or you die';
print_r(makeCensored($sentence, ['die', 'play']));
// => When you $#%! the game of thrones, you win or you $#%!

$sentence2 = 'chicken chicken? chicken! chicken';
print_r(makeCensored($sentence2, ['?', 'chicken']));
// => '$#%! chicken? chicken! $#%!';