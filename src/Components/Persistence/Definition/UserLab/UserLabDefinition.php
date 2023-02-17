<?php

declare(strict_types=1);

namespace RDD\Lab1\Components\Persistence\Definition\UserLab;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityProtection\EntityProtectionCollection;
use Shopware\Core\Framework\DataAbstractionLayer\EntityProtection\WriteProtection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\SearchRanking;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\PasswordField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class UserLabDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'user_lab';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return UserLabCollection::class;
    }

    public function getEntityClass(): string
    {
        return UserLabEntity::class;
    }

    public function since(): ?string
    {
        return '6.0.0.0';
    }

    public function getDefaults(): array
    {
        return [
            'timeZone' => 'UTC',
        ];
    }

    protected function defineProtections(): EntityProtectionCollection
    {
        return new EntityProtectionCollection([new WriteProtection(Context::SYSTEM_SCOPE)]);
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection(
            [
                (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
                (new StringField('username', 'username'))->addFlags(
                    new Required(),
                    new SearchRanking(
                        SearchRanking::HIGH_SEARCH_RANKING
                    )
                ),
                (new PasswordField('password', 'password'))->removeFlag(ApiAware::class)->addFlags(new Required()),
                (new StringField('first_name', 'firstName'))->addFlags(
                    new Required(),
                    new SearchRanking(
                        SearchRanking::HIGH_SEARCH_RANKING
                    )
                ),
                (new StringField('last_name', 'lastName'))->addFlags(
                    new Required(),
                    new SearchRanking(
                        SearchRanking::HIGH_SEARCH_RANKING
                    )
                ),
                 (new StringField('email', 'email'))->addFlags(
                    new Required(),
                    new SearchRanking(SearchRanking::HIGH_SEARCH_RANKING)
                ),
                new BoolField('active', 'active')
            ]
        );
    }
}
