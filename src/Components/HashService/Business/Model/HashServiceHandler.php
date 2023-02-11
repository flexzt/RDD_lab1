<?php

declare(strict_types=1);

namespace RDD\Lab1\Components\HashService\Business\Model;

use Doctrine\DBAL\Connection;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Util\Random;
use Shopware\Core\Framework\Uuid\Uuid;

class HashServiceHandler implements HashServiceHandlerInterface
{
    public function __construct(
        private readonly Connection $connection,
        private readonly EntityRepository $entityRepository
    ) {
    }

    public function provision(string $username, ?string $password = null, array $additionalData = []): string
    {
        if ($this->userExists($username)) {
            throw new \RuntimeException(sprintf('User with username "%s" already exists.', $username));
        }

        $password = $password ?? Random::getAlphanumericString(8);

        $id = Uuid::randomBytes();

        $salt = Uuid::fromBytesToHex($id);

        $userPayload = [
            'id'         => $id,
            'first_name' => $additionalData['firstName'] ?? '',
            'last_name'  => $additionalData['lastName'] ?? $username,
            'email'      => $additionalData['email'] ?? '',
            'username'   => $username,
            'password'   => md5($password . $salt),
            'active'     => true,
            'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
        ];

        $this->connection->insert('user_lab', $userPayload);

        return $password;
    }

    private function userExists(string $username): bool
    {
        $builder = $this->connection->createQueryBuilder();

        return $builder->select('1')
                ->from('user_lab')
                ->where('username = :username')
                ->setParameter('username', $username)
                ->execute()
                ->rowCount() > 0;
    }
}
