<?php

namespace WonderWp\Component\BlockStyle\Definition;

abstract class AbstractBlockStyle implements BlockStyleInterface
{
    /** @var string */
    protected string $key;

    /** @var array */
    protected array $args = [];

    /** @inerhitDoc */
    public function getKey(): string
    {
        return $this->key;
    }

    /** @inerhitDoc */
    public function setKey(string $key): static
    {
        $this->key = $key;
        return $this;
    }

    /** @inerhitDoc */
    public function getArgs(): array
    {
        return $this->args;
    }

    /** @inerhitDoc */
    public function setArgs(array $args): static
    {
        $this->args = $args;
        return $this;
    }
}
