<?php

declare(strict_types=1);

namespace RDD\Lab1\Components\Persistence\Definition\UserLab;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

class UserLabCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return UserLabEntity::class;
    }
}