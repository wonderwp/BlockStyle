<?php

namespace WonderWp\Component\BlockStyle\Traits;

trait HasBlockStyleAutoloader
{
    /**
     * Customize discovery paths for block styles.
     *
     * @param array $discoveryPaths
     * @return array
     */
    protected function resolveDiscoveryPaths(array $discoveryPaths): array
    {
        $discoveryPathsRoots = $this->manager->getConfig('discoveryPathsRoots', [
            'block-styles' => rtrim($this->manager->getConfig('path.root') ?? '', DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR,
        ]);

        $discoverFolderSuffix = $this->manager->getConfig('cptservice.discoverFolderSuffix', 'BlockStyles');
        $defaultPaths         = $this->deductDefaultDiscoveryPaths($discoveryPathsRoots, $discoverFolderSuffix);

        return array_merge($defaultPaths, $discoveryPaths);
    }

    /**
     * After autoloading, register discovered block styles.
     *
     * @param array    $result
     * @param array    $classNameFromFiles
     * @param array    $discoveryPaths
     * @param callable $successCallback
     * @param array    $excludedClasses
     *
     * @return array
     */
    protected function afterAutoload(
        array $result,
        array $classNameFromFiles,
        array $discoveryPaths,
        callable $successCallback,
        array $excludedClasses
    ): array {
        if (!empty($this->blockStyles)) {
            $this->registerBlockStyles();
        }

        return $result;
    }
}


