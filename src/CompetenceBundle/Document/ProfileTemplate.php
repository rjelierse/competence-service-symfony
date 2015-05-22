<?php

namespace Sparse\CompetenceBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Template for a competence profile.
 *
 * @author Raymond Jelierse <raymond@shareworks.nl>
 *         
 * @MongoDB\Document(collection="competences.templates")
 * @MongoDB\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class ProfileTemplate 
{
    /**
     * The template identifier.
     * 
     * @MongoDB\Id()
     * @Serializer\Type("string")
     * @Serializer\ReadOnly()
     */
    private $id;

    /**
     * The template name.
     * 
     * @MongoDB\String()
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * The competence templates.
     * 
     * @MongoDB\EmbedMany(targetDocument="Sparse\CompetenceBundle\Document\CompetenceTemplate")
     * @Serializer\Type("ArrayCollection<Sparse\CompetenceBundle\Document\CompetenceTemplate>")
     * @Assert\Valid()
     */
    private $competences;

    /**
     * Extra points that can be assigned to any competence in the template.
     * 
     * @MongoDB\Integer()
     * @Serializer\Type("integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $extraPoints = 0;
    
    public static function create()
    {
        return new static();
    }
    
    public function __construct()
    {
        $this->competences = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * @return Collection|CompetenceTemplate[]
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     * @return mixed
     */
    public function getExtraPoints()
    {
        return $this->extraPoints;
    }
    
    public function setExtraPoints($points)
    {
        $this->extraPoints = $points;
        
        return $this;
    }
}
