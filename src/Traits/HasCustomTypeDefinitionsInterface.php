<?php

namespace WonderWp\Component\BlockStyle\Traits;

use WonderWp\Component\BlockStyle\BlockStyleInterface;

interface HasCustomTypeDefinitionsInterface
{
    /**
     * Provide the key of the custom post type
     * @see BlockStyleInterface::setKey()
     * @return string
     */
    public static function provideKey(): string;

    /**
     * Provide the args of the custom post type
     * @see BlockStyleInterface::setArgs()
     * @return array
     */
    public static function provideArgs(): array;
}
