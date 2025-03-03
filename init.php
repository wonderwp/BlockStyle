<?php

use WonderWp\Component\BlockStyle\Service\BlockStyleService;
use WonderWp\Component\BlockStyle\Service\BlockStyleServiceInterface;
use WonderWp\Component\PluginSkeleton\Exception\ServiceNotFoundException;
use WonderWp\Component\PluginSkeleton\ManagerAwareInterface;
use WonderWp\Component\Service\ServiceInterface;
use WonderWp\Component\PluginSkeleton\ManagerInterface;
use WonderWp\Component\DependencyInjection\Container;

add_action('wonderwp.loader.load', 'wwp_register_blockStyle_definitions_towards_container', 10, 2);
add_action('wwp.abstract_manager.run', 'wwp_register_blockStyle_service_towards_manager', 10, 2);

function wwp_register_blockStyle_definitions_towards_container(Container $container)
{
    /**
     * Block Types
     */
    $container['wwp.blockStyle.defaultService'] = $container->factory(function () {
        return new BlockStyleService();
    });
}

function wwp_register_blockStyle_service_towards_manager(ManagerInterface $manager, Container $container)
{
    //Block Types
    try {
        $blockStyleService = $manager->getService(ServiceInterface::BLOCK_STYLE_SERVICE_NAME);
        if ($blockStyleService instanceof BlockStyleServiceInterface) {
            $blockStyleService->register();
        }
    } catch (ServiceNotFoundException $e) {
        if ($e->getServiceType() === ServiceInterface::BLOCK_STYLE_SERVICE_NAME) {
            //No block type service found, use the default one instead
            $blockStyleService = $container['wwp.blockStyle.defaultService'];
            if ($blockStyleService instanceof BlockStyleServiceInterface) {
                if ($blockStyleService instanceof ManagerAwareInterface) {
                    $blockStyleService->setManager($manager);
                }
                $blockStyleService->register();
            }
        } else {
            throw $e;
        }
    }
}
