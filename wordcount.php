<?php

require __DIR__ . "/vendor/autoload.php";

if (php_sapi_name() != "cli") {
    echo "Oops... Try to use CLI.";
    return;
}

$filename = $argv[1];

if (!file_exists($filename)) {
    echo "Give me another file, please." . PHP_EOL;
    return;
};

$start = microtime(true);

$app = new \App\App();

$app->run($filename);

$end = microtime(true);

echo 'Time spent: ' . floor(($end-$start)/60) . ' min ' . (($end-$start)%60) . ' s' . PHP_EOL;
