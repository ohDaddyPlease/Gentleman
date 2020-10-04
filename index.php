<?php

require 'vendor/autoload.php';
require 'Gentleman/functions.php';

use Gentleman\Gentleman;

try {
    Gentleman::configure();
    Gentleman::run();
}catch(Exception $e) {
    Gentleman::$logger->error($e->getMessage());
}