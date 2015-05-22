<?php

namespace Sparse\CompetenceBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Template for a competence.
 *
 * @author Raymond Jelierse <raymond@shareworks.nl>
 *         
 * @MongoDB\EmbeddedDocument()
 */
class CompetenceTemplate 
{
    /**
     * The competence name.
     * 
     * @MongoDB\String()
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * The lower limit for the points that can be assigned to this competence.
     * 
     * @MongoDB\Integer()
     * @Serializer\Type("integer")
     * @Assert\GreaterThan(0)
     */
    private $points;

    public static function create($name, $points)
    {
        $competence = new static();
        
        return $competence
            ->setName($name)
            ->setPoints($points);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return static
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param integer $points
     *
     * @return static
     */
    public function setPoints($points)
    {
        $this->points = $points;
        
        return $this;
    }
}
