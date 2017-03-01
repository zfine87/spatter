<?php

// WEBROOT: public/index.php

//Composer Autoloader
$loader = require __DIR__.'/../vendor/autoload.php';

//Static resource allowing (ONLY FOR local dev PHP webserver and need to avoid when testing)
if(!getenv('env')) {
    $filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
    if (php_sapi_name() === 'cli-server' && is_file($filename)) {
        return false;
    }
}


//Start App
$app = new App\Application();

$app->run();

return $app;
