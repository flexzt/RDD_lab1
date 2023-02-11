<?php


declare(strict_types=1);

namespace RDD\Lab1\Components\Persistence\Definition\UserLab;

use Shopware\Core\Checkout\Order\OrderCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCustomFieldsTrait;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class UserLabEntity extends Entity
{
    use EntityIdTrait;
    use EntityCustomFieldsTrait;


    /**
     * @var string
     */
    protected $username;

    /**
     * @deprecated tag:v6.5.0 - Will be internal from 6.5.0 onward
     *
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string|null
     */
    protected $title;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var bool
     */
    protected $active;

    /**
     * @var bool
     */
    protected $admin;

    /**
     * @var \DateTimeInterface|null
     */
    protected $lastUpdatedPasswordAt;

    /**
     * @var OrderCollection|null
     */
    protected $createdOrders;

    /**
     * @var OrderCollection|null
     */
    protected $updatedOrders;

    protected string $timeZone;


    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @deprecated tag:v6.5.0 - reason:becomes-internal - Will be internal from 6.5.0 onward
     */
    public function getPassword(): string
    {
        $this->checkIfPropertyAccessIsAllowed('password');

        return $this->password;
    }

    /**
     * @deprecated tag:v6.5.0 - reason:becomes-internal - Will be internal from 6.5.0 onward
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function isAdmin(): bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): void
    {
        $this->admin = $admin;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getCreatedOrders(): ?OrderCollection
    {
        return $this->createdOrders;
    }

    public function setCreatedOrders(OrderCollection $createdOrders): void
    {
        $this->createdOrders = $createdOrders;
    }

    public function getUpdatedOrders(): ?OrderCollection
    {
        return $this->updatedOrders;
    }

    public function setUpdatedOrders(OrderCollection $updatedOrders): void
    {
        $this->updatedOrders = $updatedOrders;
    }

    public function getLastUpdatedPasswordAt(): ?\DateTimeInterface
    {
        return $this->lastUpdatedPasswordAt;
    }

    public function setLastUpdatedPasswordAt(\DateTimeInterface $lastUpdatedPasswordAt): void
    {
        $this->lastUpdatedPasswordAt = $lastUpdatedPasswordAt;
    }

    public function getTimeZone(): string
    {
        return $this->timeZone;
    }

    public function setTimeZone(string $timeZone): void
    {
        $this->timeZone = $timeZone;
    }
}
