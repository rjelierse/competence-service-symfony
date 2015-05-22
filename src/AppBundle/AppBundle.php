<?php

namespace Sparse\AppBundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle 
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/Resources/config'));
        $loader->load('services.xml');
        $loader->load('security.xml');
    }
}
