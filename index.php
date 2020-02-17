<?php

session_start();

require 'vendor/autoload.php';

$app = \App\ApplicationBuilder::make();
$app->run();

return $app;
