<?php
namespace Model\Dao;
use PDO;

$db = ($_SERVER["SERVER_NAME"]=="localhost")?$config_db["db_dev"]:$config_db["db_prod"];

define('host',$db["host"]);
define('dbuser',$db["user"]);
define('dbpassword',$db["password"]);
define('dbname',$db["name"]);


class Connection {

    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {

            self::$instance = new PDO("mysql:host=".host.";dbname=".dbname."", dbuser, dbpassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
        }

        return self::$instance;
    }

}