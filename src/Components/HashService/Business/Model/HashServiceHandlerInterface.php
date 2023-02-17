<?php

declare(strict_types=1);

namespace RDD\Lab1\Components\HashService\Business\Model;

use RDD\Lab1\Components\Persistence\Definition\UserLab\UserLabEntity;

interface HashServiceHandlerInterface
{

    public function validate(UserLabEntity $userLabEntity, string $password): bool;
}
