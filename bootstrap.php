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
    'password' => 'password',
    'host' => 'localhost',
    'port' => '3306',
    'driver' => 'pdo_mysql',
);

// Get the entity manager
$entityManager = EntityManager::create($conn, $config);