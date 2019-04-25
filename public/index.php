<?php

require_once '../vendor/autoload.php';

use App\Bingo;

$param = isset($argv[1]) ? $argv[1] : 'draw';
print_r((new Bingo())->getBingo($param));
echo PHP_EOL;