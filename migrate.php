<?php

/**
 * TODO: Update changelogs in /docs/migration.md file to save changes in database version
 * 
 * Format of changelog:
 *      ## Version 1
 *      1. Create `users` table.
 */

use Dotenv\Dotenv;
use Src\Helpers\Dir;
use Src\Helpers\Migration;

require_once("./src/conf.php");
require_once("./vendor/autoload.php");

Dotenv::createImmutable(Dir::getRootDir())->load();

$migration = new Migration();

// Set migration version
$migration->setVersion(3);

/** =============== Queries =================== */

$migration->query("CREATE TABLE IF NOT EXISTS users (
    uid VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    created_at INT NOT NULL,
    updated_at INT NOT NULL,
    PRIMARY KEY (uid)
)", 1);

$migration->query("ALTER TABLE users ADD password VARCHAR(255) NOT NULL AFTER name", 2);

$migration->query("ALTER TABLE users ADD remember_token VARCHAR(255) AFTER password", 2);

/** =============== End queries =============== */

// Run migration
$migration->run();
