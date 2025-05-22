<!-- /**
 * Database Configuration File
 * 
 * This file handles the database connection setup and initialization for the PC Shop application.
 * It establishes a PDO connection to a MySQL database with specific credentials and configuration.
 * 
 * Configuration Parameters:
 * @var string $host     Database host (default: 'localhost')
 * @var string $db       Database name (default: 'pcshop')
 * @var string $user     Database username (default: 'root')
 * @var string $pass     Database password (default: empty)
 * @var string $charset  Database character set (default: 'utf8mb4')
 * 
 * PDO Configuration:
 * - Error Mode: Exception
 * - Default Fetch Mode: Associative Array
 * 
 * @throws PDOException If database connection fails
 * @return PDO Returns PDO connection object
  * @author     Joseph Abou Antoun 52330567

 */ -->
<?php
session_start();

$host = 'localhost';
$db   = 'pcshop';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     exit('Database error.');
}
?>
