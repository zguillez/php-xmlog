<?php

require 'vendor/autoload.php';

$log = new Z\Log("log", "./logs/");
echo $log->insert(Log::XML, 'Esto es un update!', false, true, true);