<?php

namespace Sparse\AppBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Validator\Constraint;

/**
 * Helper class for the controllers.
 *
 * @author Raymond Jelierse <raymond@shareworks.nl>
 */
abstract class AbstractController extends FOSRestController 
{
    public function getDoctrine()
    {
        return $this->get('doctrine_mongodb');
    }

    /**
     * @param string $class
     *
     * @return ObjectManager
     */
    public function getManager($class)
    {
        return $this->getDoctrine()->getManagerForClass($class);
    }

    /**
     * @param string $class
     *
     * @return ObjectRepository
     */
    public function getRepository($class)
    {
        return $this->getDoctrine()->getRepository($class);
    }
    
    public function validate($object, $group)
    {
        $group = is_array($group) ? $group : [$group];
        $group[] = Constraint::DEFAULT_GROUP;
        
        return $this->get('validator.builder')
            ->enableAnnotationMapping()
            ->getValidator()
            ->validate($object, $group);
    }
}
