<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Yaml\Yaml;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/AppBundle/Models"), $isDevMode);

// Database Configs
$conn = Yaml::parse(file_get_contents(__DIR__.'/src/AppBundle/Config/database.yml'));

// Get the entity manager
$entityManager = EntityManager::create($conn, $config);