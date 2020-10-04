<?php

require 'vendor/autoload.php';
require 'Gentleman/auxiliary/auxiliary.php';

use Gentleman\Gentleman;

try {
    Gentleman::configure();
    Gentleman::run();
}catch(\Throwable $e) {
    Gentleman::$logger->error($e->getMessage());
}