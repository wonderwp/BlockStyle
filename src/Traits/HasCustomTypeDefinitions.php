<?php

namespace WonderWp\Component\BlockStyle\Traits;

trait HasCustomTypeDefinitions
{
    public function __construct()
    {
        $key = static::provideKey();
        $args = static::provideArgs();
        parent::__construct($key, $args);
    }
}
