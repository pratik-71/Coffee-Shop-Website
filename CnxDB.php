<?php class CnxDB
{
private static $_dbname;
private static $_user;
private static $_pwd;
private static $_host;
private static $_socket;
private static $_bdd = null;

private function __construct()
{
self::$_dbname = getenv('DB_NAME') ?: 'ooplogin';
self::$_user = getenv('DB_USER') ?: 'root';
self::$_pwd = getenv('DB_PASS') ?: '';
self::$_host = getenv('DB_HOST') ?: '127.0.0.1';
self::$_socket = getenv('DB_SOCKET') ?: null;

try {
if (self::$_socket) {
    $dsn = 'mysql:unix_socket=' . self::$_socket . ';dbname=' . self::$_dbname . ';charset=utf8';
} else {
    $dsn = 'mysql:host=' . self::$_host . ';dbname=' . self::$_dbname . ';charset=utf8';
}
self::$_bdd = new PDO(
    $dsn,
    self::$_user,
    self::$_pwd,
    array((defined('PDO::MYSQL_ATTR_INIT_COMMAND') ? PDO::MYSQL_ATTR_INIT_COMMAND : 1002) => 'SET NAMES UTF8')
);
} catch (PDOException $e) {
die('Erreur : ' . $e->getMessage());
}
}

public static function getInstance()
{
if (!self::$_bdd) {
new CnxDB();
}
return (self::$_bdd);
}
}
?>