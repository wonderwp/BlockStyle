<?php

namespace WonderWp\Component\BlockStyle\Service;


use WonderWp\Component\BlockStyle\Definition\BlockStyleInterface;
use WonderWp\Component\BlockStyle\Exception\BlockStyleRegistrationException;
use WonderWp\Component\BlockStyle\Response\BlockStyleRegistrationResponseInterface;
use WonderWp\Component\PluginSkeleton\Service\RegistrableInterface;

interface BlockStyleServiceInterface extends RegistrableInterface
{
    /**
     * @return BlockStyleInterface[]
     */
    public function getBlockStyles(): array;

    /**
     * @param string $key
     * @return BlockStyleInterface|null
     */
    public function getBlockStyle(string $key): ?BlockStyleInterface;

    /**
     * @param BlockStyleInterface $blockStyle
     * @return $this
     */
    public function addBlockStyle(BlockStyleInterface $blockStyle): static;

    /**
     * @param string $key
     * @return $this
     */
    public function removeBlockStyle(string $key): static;

    /**
     * @param BlockStyleInterface[] $blockStyles
     * @return $this
     */
    public function setBlockStyles(array $blockStyles): static;

    /**
     * Register all BlockStyles
     *
     * @return BlockStyleRegistrationResponseInterface[]
     * @throws BlockStyleRegistrationException
     */
    public function registerBlockStyles(): array;

    /**
     * Register a BlockStyle
     *
     * @param BlockStyleInterface $blockStyle
     * @return BlockStyleRegistrationResponseInterface
     * @throws BlockStyleRegistrationException
     */
    public function registerBlockStyle(BlockStyleInterface $blockStyle): BlockStyleRegistrationResponseInterface;
}
