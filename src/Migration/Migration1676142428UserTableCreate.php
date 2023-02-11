<?php declare(strict_types=1);

namespace RDD\Lab1\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1676142428UserTableCreate extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1676142428;
    }

    public function update(Connection $connection): void
    {
        $connection->executeUpdate('
            CREATE TABLE `user_lab` (
              `id`              BINARY(16)                              NOT NULL,
              `username`        VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
              `password`        VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
              `first_name`      VARCHAR(255)                            NOT NULL,
              `last_name`       VARCHAR(255)                            NOT NULL,
              `email`           VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
              `active`          TINYINT(1)                              NOT NULL DEFAULT 0,
              `custom_fields`   JSON                                    NULL,
              `created_at`      DATETIME(3)                             NOT NULL,
              `updated_at`      DATETIME(3)                             NULL,
              PRIMARY KEY (`id`),
              CONSTRAINT `uniq.user_lab.email` UNIQUE (`email`),
              CONSTRAINT `uniq.user_lab.username` UNIQUE (`username`),
              CONSTRAINT `json.user_lab.custom_fields` CHECK (JSON_VALID(`custom_fields`))
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
