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

    public function autoload(array $classNameFromFiles = [], array $discoveryPaths = [], callable $successCallback = null, array $excludedClasses=[]): array
    {
        $discoveryPathsRoots = $this->manager->getConfig('discoveryPathsRoots', [
            'block-styles' => rtrim($this->manager->getConfig('path.root') ?? '', DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR
        ]);
        $discoverFolderSuffix = $this->manager->getConfig('cptservice.discoverFolderSuffix', 'BlockStyles');
        $defaultPaths = $this->deductDefaultDiscoveryPaths($discoveryPathsRoots, $discoverFolderSuffix);
        $discoveryPaths = array_merge($defaultPaths, $discoveryPaths);

        $autoLoaded = parent::autoload($classNameFromFiles, $discoveryPaths, $successCallback);

        if (!empty($this->blockStyles)) {
            $this->registerBlockStyles();
        }

        return $autoLoaded;
    }

    protected function autoloadFile(string $className, string $filePath): object
    {
        $instance = parent::autoloadFile($className, $filePath);

        $this->addBlockStyle($instance);

        return $instance;
    }

}
