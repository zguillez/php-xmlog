<?php

require 'vendor/autoload.php';

use Z\Log;

$params = [];
$params["type"]   = Log::LOG;
$params["filename"]   = "register";
$params["path"]   = "./logs/";
$params["dated"]  = false;
$params["clear"]  = false;
$params["backup"] = false;

$log = new Log($params);

$log->config(["dated"=>true]);

$log->insert('This is update one!');
$log->insert('This is update two!');