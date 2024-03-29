<?php

namespace App\CQRS;

use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\Attribute\QueryHandler;
use InvalidArgumentException;

/**
 * test 0.10.0-rc.9
 */
class OrderService
{
    private array $orders;

    #[CommandHandler]
    public function placeOrder(PlaceOrder $command): void
    {
        $this->orders[$command->getOrderId()] = $command->getProductName();
    }

    #[QueryHandler]
    public function getOrder(GetOrder $query): string
    {
        if (! array_key_exists($query->getOrderId(), $this->orders)) {
            throw new InvalidArgumentException('Order was not found ' . $query->getOrderId());
        }

        return $this->orders[$query->getOrderId()];
    }
}
