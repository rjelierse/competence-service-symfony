<?php

namespace Sparse;

use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use FOS\RestBundle\FOSRestBundle;
use JMS\AopBundle\JMSAopBundle;
use JMS\DiExtraBundle\JMSDiExtraBundle;
use JMS\SecurityExtraBundle\JMSSecurityExtraBundle;
use JMS\SerializerBundle\JMSSerializerBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Sparse\AppBundle\AppBundle;
use Sparse\CompetenceBundle\CompetenceBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel 
{
    public function __construct($environment, $debug)
    {
        parent::__construct($environment, $debug);
        
        AnnotationDriver::registerAnnotationClasses();
    }

    public function registerBundles()
    {
        $bundles = [];
        
        // Third-party bundles
        $bundles[] = new FrameworkBundle();
        $bundles[] = new SecurityBundle();
        $bundles[] = new TwigBundle();
        $bundles[] = new DoctrineMongoDBBundle();
        $bundles[] = new JMSSerializerBundle();
        $bundles[] = new FOSRestBundle();
        $bundles[] = new SensioFrameworkExtraBundle();
        $bundles[] = new JMSAopBundle();
        $bundles[] = new JMSSecurityExtraBundle();
        
        // Development bundles
        if ($this->environment === 'dev') {
            $bundles[] = new DebugBundle();
            $bundles[] = new WebProfilerBundle();
            $bundles[] = new DoctrineFixturesBundle();
        }
        
        // Application bundles
        $bundles[] = new AppBundle();
        $bundles[] = new CompetenceBundle();
        
        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/common/config.yml');
        $loader->load($this->getRootDir() . '/' . $this->environment . '/config.yml');
    }

    public function getName()
    {
        return 'competence_campus';
    }

    public function getRootDir()
    {
        return __DIR__ . '/../etc';
    }

    public function getCacheDir()
    {
        return __DIR__ . '/../var/cache/' . $this->environment;
    }

    public function getLogDir()
    {
        return __DIR__ . '/../var/log';
    }
}
