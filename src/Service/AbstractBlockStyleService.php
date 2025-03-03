<?php

namespace WonderWp\Component\BlockStyle\Service;

use WonderWp\Component\BlockStyle\Definition\BlockStyleInterface;
use WonderWp\Component\BlockStyle\Exception\BlockStyleRegistrationException;
use WonderWp\Component\BlockStyle\Response\BlockStyleRegistrationResponse;
use WonderWp\Component\BlockStyle\Response\BlockStyleRegistrationResponseInterface;
use WonderWp\Component\Service\AbstractService;

abstract class AbstractBlockStyleService extends AbstractService implements BlockStyleServiceInterface
{
    /** @var BlockStyleInterface[] */
    protected array $blockStyles = [];

    public function getBlockStyles(): array
    {
        return $this->blockStyles;
    }

    public function getBlockStyle(string $key): ?BlockStyleInterface
    {
        return $this->blockStyles[$key] ?? null;
    }

    public function addBlockStyle(BlockStyleInterface $BlockStyle): static
    {
        $this->blockStyles[$BlockStyle->getKey()] = $BlockStyle;

        return $this;
    }

    public function removeBlockStyle(string $key): static
    {
        if (isset($this->blockStyles[$key])) {
            unset($this->blockStyles[$key]);
        }

        return $this;
    }

    public function setBlockStyles(array $BlockStyles): static
    {
        $this->blockStyles = $BlockStyles;

        return $this;
    }

    //========================================================================================================//
    // Registration methods
    //========================================================================================================//

    public function registerBlockStyles(): array
    {
        $responses = [];

        foreach ($this->blockStyles as $blockStyle) {
            $responses[$blockStyle->getKey()] = $this->registerBlockStyle($blockStyle);
        }

        return $responses;
    }

    public function registerBlockStyle(BlockStyleInterface $blockStyle): BlockStyleRegistrationResponseInterface
    {
        try {
            $wpRes = \register_block_style($blockStyle->getKey(), $blockStyle->getArgs());

            if (!$wpRes) {
                throw new BlockStyleRegistrationException(500, BlockStyleRegistrationResponseInterface::ERROR);
            } else {
                $response = new BlockStyleRegistrationResponse(200, BlockStyleRegistrationResponseInterface::SUCCESS);
            }
        } catch (\Exception $e) {
            $errorCode = is_int($e->getCode()) ? $e->getCode() : 500;
            $response = new BlockStyleRegistrationResponse($errorCode, BlockStyleRegistrationResponseInterface::ERROR);
            $response->setError($e);
        }

        return $response;
    }


}
