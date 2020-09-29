<?php

namespace Logging;

require 'vendor/autoload.php';

use Monolog\Logger as monologLogger;
use Monolog\Handler\StreamHandler;

class Logger extends monologLogger{}