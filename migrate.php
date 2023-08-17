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

require_once("./src/configs.php");
require_once("./vendor/autoload.php");

Dotenv::createImmutable(Dir::getRootDir())->load();

$migration = new Migration();

// Set migration version
$migration->setVersion(1);

/** =============== Queries =================== */

$migration->query("CREATE TABLE IF NOT EXISTS users (
    uid VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email_verified_at INT,
    created_at INT NOT NULL,
    updated_at INT NOT NULL,
    deleted_at INT,
    PRIMARY KEY (uid)
)", 1);

$migration->query("INSERT INTO `users` (`uid`, `name`, `email`, `password`, `email_verified_at`, `created_at`, `updated_at`, `deleted_at`) 
    VALUES (
        '993bcf91-e209-4e1c-8b72-54ffde2b3a1d',
        'Administrator',
        'admin@gmail.com',
        'bb6a3d082a55bf08c99e496195148324',
        '1689243617',
        '1689243617',
        '1689243617',
        NULL
)", 1);

$migration->query("CREATE TABLE IF NOT EXISTS queue_jobs (
    uid VARCHAR(255) NOT NULL,
    class VARCHAR(255) NOT NULL,
    data VARCHAR(255) NOT NULL,
    status INT NOT NULL DEFAULT " . QUEUE_STATUS_OPEN . "
)", 1);

$migration->query("CREATE TABLE IF NOT EXISTS `tokens` (
    `uid` VARCHAR(255) NOT NULL ,
    `user_uid` VARCHAR(255) NOT NULL ,
    `token_type` VARCHAR(255) NOT NULL ,
    `token` VARCHAR(255) NOT NULL ,
    `created_at` INT NOT NULL ,
    `expired_at` INT NOT NULL ,
    PRIMARY KEY (`uid`)
    ) ENGINE = InnoDB;
", 2);

$migration->query("ALTER TABLE `tokens` 
    ADD CONSTRAINT `token_uid_user_uid` 
    FOREIGN KEY (`user_uid`) 
    REFERENCES `users`(`uid`) 
    ON DELETE RESTRICT 
    ON UPDATE RESTRICT
", 2);

$migration->query("ALTER TABLE `tokens` 
    ADD UNIQUE `token` (`token`)
    USING BTREE;
", 2);

/** =============== End queries =============== */

// Run migration
$migration->run(isset($argv[1]) && $argv[1] === "--all");
