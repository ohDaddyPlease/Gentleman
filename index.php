<?php

require 'Gentleman/Gentleman.php';

use Gentleman\Gentleman;

Gentleman::configure();
Gentleman::registerStartPoint($_ENV['START_POINT']);
Gentleman::run();