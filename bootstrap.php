<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/AppBundle/Models"), $isDevMode);

// Database Configs
$conn = array(
    'dbname' => 'spatter',
    'user' => 'root',
    'password' => 'Samps0n1$',
    'host' => 'localhost',
    'port' => '3306',
    'driver' => 'pdo_mysql',
);


if(getenv("CLEARDB_DATABASE_URL")) {
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $conn = array(
        'dbname' => substr($url["path"], 1),
        'user' => $url["user"],
        'password' => $url["pass"],
        'host' => $url["host"],
        'port' => $url["port"],
        'driver' => 'pdo_mysql'
    );
} else {
    $conn = array(
        'dbname' => 'spatter',
        'user' => 'root',
        'password' => 'Samps0n1$',
        'host' => 'localhost',
        'port' => '3306',
        'driver' => 'pdo_mysql',
    );
}

// Get the entity manager
$entityManager = EntityManager::create($conn, $config);