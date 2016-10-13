<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if (PHP_SAPI == 'cli-server') {
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}
require __DIR__ . '/vendor/autoload.php';
session_start();
$settings = require __DIR__ . '/src/settings.php';
$app = new \Slim\App($settings);

require __DIR__ . '/src/dependencies.php';
require __DIR__ . '/src/middleware.php';
require __DIR__ . '/src/routes.php';
$config_db = require __DIR__ . '/src/config_db.php';
require __DIR__ . '/src/connection.php';
require __DIR__ . '/src/Model/Entity/Comentarios.php';
require __DIR__ . '/src/Model/Dao/DaoComentarios.php';
require __DIR__ . '/src/Model/Compomentes/JsonEncodePrivate.php';
require __DIR__ . '/src/Model/Compomentes/RegisterLog.php';
$app->run();
