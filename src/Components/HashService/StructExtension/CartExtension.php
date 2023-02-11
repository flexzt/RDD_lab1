<?php declare(strict_types=1);

namespace RDD\Lab1\Components\VipService\StructExtension;

use Shopware\Core\Framework\Struct\Struct;

class CartExtension extends Struct
{
    public const KEY = 'cart-vip-service';

    protected bool $vipMinCartValueReached = false;

    protected float $vipMinCartValue = 0.0;

    public function isVipMinCartValueReached(): bool
    {
        return $this->vipMinCartValueReached;
    }

    public function setVipMinCartValueReached(bool $vipMinCartValueReached): void
    {
        $this->vipMinCartValueReached = $vipMinCartValueReached;
    }

    public function getVipMinCartValue(): float
    {
        return $this->vipMinCartValue;
    }

    public function setVipMinCartValue(float $vipMinCartValue): void
    {
        $this->vipMinCartValue = $vipMinCartValue;
    }
}
