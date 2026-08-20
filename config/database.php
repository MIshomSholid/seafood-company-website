<?php

class Database
{
    private static ?PDO $connection = null;

    private static string $host = 'localhost';
    private static string $database = 'samudra_kencana_mina';
    private static string $username = 'root';
    private static string $password = '';

    /**
     * Mendapatkan koneksi database.
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {

            try {

                $dsn = "mysql:host=" . self::$host
                    . ";dbname=" . self::$database
                    . ";charset=utf8mb4";

                self::$connection = new PDO(
                    $dsn,
                    self::$username,
                    self::$password
                );

                self::$connection->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

                self::$connection->setAttribute(
                    PDO::ATTR_DEFAULT_FETCH_MODE,
                    PDO::FETCH_ASSOC
                );

                self::$connection->setAttribute(
                    PDO::ATTR_EMULATE_PREPARES,
                    false
                );

            } catch (PDOException $e) {

                die(
                    'Database connection failed: '
                    . $e->getMessage()
                );
            }
        }

        return self::$connection;
    }
}