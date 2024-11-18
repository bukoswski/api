<?php



define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'api');


class Database
{
    private static  $connection;

    private function __construct()
    {
        // O construtor é privado para prevenir a instanciação direta.
    }

    public static function getConnection()
    {
        if (!isset(self::$connection)) {
            self::$connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
            if (self::$connection->connect_error) {
                die("Conexão falhou: " . self::$connection->connect_error);
            }
        }
        return self::$connection;
    }
}
$connection = Database::getConnection();
if ($connection) {
    //echo "Conexão realizada com sucesso!";
}
