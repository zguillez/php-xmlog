<?php

require 'vendor/autoload.php';

use Z\Log;

$log = new Log("registro", "./logs/");

echo $log->insert(Log::LOG, 'Esto es un update!', false, true, true);
echo $log->insert(Log::XML, 'Esto es un update!', false, true, true);