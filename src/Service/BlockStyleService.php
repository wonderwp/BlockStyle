<?php

namespace WonderWp\Component\BlockStyle\Service;

use WonderWp\Component\BlockStyle\Definition\BlockStyleInterface;
use WonderWp\Component\BlockStyle\Exception\BlockStyleRegistrationException;
use WonderWp\Component\BlockStyle\Response\BlockStyleRegistrationResponse;
use WonderWp\Component\PluginSkeleton\ManagerAwareTrait;

class BlockStyleService extends AbstractBlockStyleService
{
    use ManagerAwareTrait;

    public function register()
    {
        add_action('init', function(){
            $autoLoaded = $this->autoload();
        },9);
    }

    protected function autoloadFile(string $className, string $filePath): object
    {
        $instance = parent::autoloadFile($className, $filePath);

        if($instance instanceof BlockStyleInterface) {
            $this->addBlockStyle($instance);
        }

        return $instance;
    }

}
