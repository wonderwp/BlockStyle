<?php

namespace WonderWp\Component\BlockStyle\Definition;

interface BlockStyleInterface
{

    /**
     * @return string
     * @see https://developer.wordpress.org/reference/functions/register_block_style/
     */
    public function getKey(): string;

    /**
     * @param string $key
     * @return BlockStyleInterface
     * @see https://developer.wordpress.org/reference/functions/register_block_style/
     */
    public function setKey(string $key): static;

    /**
     * @return array
     * @see https://developer.wordpress.org/reference/functions/register_block_style/
     */
    public function getArgs(): array;

    /**
     * @param array $args
     * @return $this
     * @see https://developer.wordpress.org/reference/functions/register_block_style/
     */
    public function setArgs(array $args): static;
}
