<?php

/**
 * TODO: Update changelogs in /docs/migration.md file to save changes in database version
 * 
 * CMD:
 *  - php migrate.php --all     (Run all queries)
 *  - php migrate.php           (Run the last version)
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
$migration->setVersion(2);

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

$migration->query("INSERT INTO `users` (`uid`, `name`, `password`, `remember_token`, `created_at`, `updated_at`) 
    VALUES (
        '993bcf91-e209-4e1c-8b72-54ffde2b3a1d',
        'Nguyễn Mạnh Thắng',
        'bb6a3d082a55bf08c99e496195148324',
        NULL,
        '1689243617',
        '1689243617'
)", 2);

/** =============== End queries =============== */

// Run migration
$migration->run(isset($argv[1]) && $argv[1] === "--all");
