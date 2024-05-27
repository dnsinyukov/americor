<?php

namespace App\Services;

final class LoanValidator
{
    /** @var callable[] */
    private array $handlers;

    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    /**
     * @param callable $handler
     * @return $this
     */
    public function add(callable $handler): self
    {
        $self = clone $this;
        $self->handlers[] = $handler;

        return $self;
    }

    /**
     * @return bool
     */
    public function apply(): bool
    {
        $conditions = [];

        /** @var LoanConditionInterface $handler */
        foreach ($this->handlers as $handler) {
            $status = $handler();

            $conditions[$handler->getName()] = $status;
        }

        return count($conditions) > 1 && count($conditions) === count(
            array_filter(array_values($conditions))
        );
    }
}