<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
header('Content-Type: text/html; charset=utf-8');

require __DIR__ . '/vendor/autoload.php';

use Minishlink\WebPush\VAPID;

print_r(VAPID::createVapidKeys());