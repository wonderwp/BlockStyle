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
    protected array $blockTypes = [];

    public function getBlockStyles(): array
    {
        return $this->blockTypes;
    }

    public function getBlockStyle(string $key): ?BlockStyleInterface
    {
        return $this->blockTypes[$key] ?? null;
    }

    public function addBlockStyle(BlockStyleInterface $BlockStyle): static
    {
        $this->blockTypes[$BlockStyle->getKey()] = $BlockStyle;

        return $this;
    }

    public function removeBlockStyle(string $key): static
    {
        if (isset($this->blockTypes[$key])) {
            unset($this->blockTypes[$key]);
        }

        return $this;
    }

    public function setBlockStyles(array $BlockStyles): static
    {
        $this->blockTypes = $BlockStyles;

        return $this;
    }

    //========================================================================================================//
    // Registration methods
    //========================================================================================================//

    public function registerBlockStyles(): array
    {
        $responses = [];

        foreach ($this->blockTypes as $blockType) {
            $responses[$blockType->getKey()] = $this->registerBlockStyle($blockType);
        }

        return $responses;
    }

    public function registerBlockStyle(BlockStyleInterface $blockType): BlockStyleRegistrationResponseInterface
    {
        try {
            $blocksOutputDir = $this->manager->getConfig('path.blocks.build');
            if (empty($blocksOutputDir)) {
                $blocksOutputDir = $this->manager->getConfig('path.root') . DIRECTORY_SEPARATOR . 'build';
                if (is_dir($blocksOutputDir . DIRECTORY_SEPARATOR . 'blocks')) {
                    $blocksOutputDir = $blocksOutputDir . DIRECTORY_SEPARATOR . 'blocks';
                }
            }

            $blocksOutputDir .= DIRECTORY_SEPARATOR . $blockType->getKey();

            $wpRes = \register_block_type($blocksOutputDir, $blockType->getArgs());

            if ($wpRes instanceof \WP_Error) {
                throw new BlockStyleRegistrationException($wpRes->get_error_message(), $wpRes->get_error_code());
            } else {
                $response = new BlockStyleRegistrationResponse(200, BlockStyleRegistrationResponseInterface::SUCCESS);
                $response->setWpRegistrationResult($wpRes);
            }
        } catch (\Exception $e) {
            $errorCode = is_int($e->getCode()) ? $e->getCode() : 500;
            $response = new BlockStyleRegistrationResponse($errorCode, BlockStyleRegistrationResponseInterface::ERROR);
            $response->setError($e);
        }

        return $response;
    }


}
