<?php

namespace Test;

use function App\Arrays\get;

$cities = ['moscow', 'london', 'berlin', 'porto'];

print_r(get($cities, 1)); // => london
print_r(get($cities, 4)); // => null
print_r(get($cities, 10, 'paris')); // => paris