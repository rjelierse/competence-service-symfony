<?php

namespace Sparse\CompetenceBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as Serializer;

/**
 * Points schema for an individual competence frame.
 *
 * @author Raymond Jelierse <raymond@shareworks.nl>
 *         
 * @MongoDB\EmbeddedDocument()
 */
class Competence
{
    /**
     * The name of the competence.
     * 
     * @MongoDB\String()
     * @Serializer\Type("string")
     * @Serializer\ReadOnly()
     */
    private $name;

    /**
     * The minimum points that are required for this competence.
     * 
     * @MongoDB\Integer()
     * @Serializer\Type("integer")
     * @Serializer\ReadOnly()
     */
    private $requiredPoints;
    
    /**
     * The points that have been assigned to this competence by the user.
     * 
     * @MongoDB\Integer()
     * @Serializer\Type("integer")
     */
    private $assignedPoints;

    /**
     * The points that have been used on a project by the user.
     * 
     * @MongoDB\Integer()
     * @Serializer\Type("integer")
     * @Serializer\ReadOnly()
     */
    private $usedPoints;
    
    public static function createFromTemplate(CompetenceTemplate $template)
    {
        return new static($template->getName(), $template->getPoints());
    }
    
    public function __construct($competence, $requiredPoints)
    {
        $this->name = $competence;
        $this->requiredPoints = $requiredPoints;
        $this->assignedPoints = $requiredPoints;
        $this->usedPoints = 0;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return integer
     */
    public function getRequiredPoints()
    {
        return $this->requiredPoints;
    }

    /**
     * @return integer
     */
    public function getAssignedPoints()
    {
        return $this->assignedPoints;
    }

    /**
     * @return integer
     */
    public function getUsedPoints()
    {
        return $this->usedPoints;
    }
}
