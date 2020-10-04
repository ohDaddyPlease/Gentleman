<?php

require 'vendor/autoload.php';
require 'Gentleman/auxiliary/auxiliary.php';

use Gentleman\Gentleman;

try {
    Gentleman::configure();
    Gentleman::run();
}catch(Exception $e) {
    Gentleman::$logger->error($e->getMessage());
}