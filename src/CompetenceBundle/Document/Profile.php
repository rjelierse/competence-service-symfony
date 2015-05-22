<?php

namespace Sparse\CompetenceBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as Serializer;
use Sparse\AppBundle\Document\User;
use Sparse\CompetenceBundle\Validator\Constraint\TotalPoints;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The competence profile contains the division of frame points.
 * 
 * @author Raymond Jelierse <raymond@shareworks.nl>
 * 
 * @MongoDB\Document(collection="competences.profiles", repositoryClass="Sparse\CompetenceBundle\Repository\CompetenceProfileRepository")
 * @MongoDB\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @TotalPoints(groups={"lock"})
 */
class Profile
{
    /**
     * The profile ID.
     * 
     * @MongoDB\Id()
     * @Serializer\Type("string")
     * @Serializer\ReadOnly()
     */
    private $id;

    /**
     * The competences for this profile.
     * 
     * @MongoDB\EmbedMany(targetDocument="Sparse\CompetenceBundle\Document\Competence")
     * @Serializer\Type("ArrayCollection<Sparse\CompetenceBundle\Document\Competence>")
     * @Assert\Valid()
     */
    private $competences;

    /**
     * The points that are available to assign to the different competences.
     * 
     * @MongoDB\Integer()
     * @Serializer\Type("integer")
     * @Serializer\ReadOnly()
     */
    private $totalPoints;

    /**
     * The student for which this profile is created.
     * 
     * @MongoDB\ReferenceOne(targetDocument="Sparse\AppBundle\Document\User", simple=true)
     * @Serializer\Type("Sparse\AppBundle\Document\User")
     * @Serializer\ReadOnly()
     * @Serializer\Exclude()
     * @Assert\NotNull()
     */
    private $student;

    /**
     * The coach for this student.
     * 
     * @MongoDB\ReferenceOne(targetDocument="Sparse\AppBundle\Document\User", simple=true)
     * @Serializer\Type("Sparse\AppBundle\Document\User")
     * @Serializer\ReadOnly()
     * @Assert\NotNull(groups={"lock"})
     */
    private $coach;

    /**
     * Flag to indicate the profile is locked.
     * 
     * @MongoDB\Boolean()
     * @Serializer\Type("boolean")
     * @Serializer\ReadOnly()
     * @Assert\True(groups={"lock"})
     * @Assert\False(groups={"update"})
     */
    private $locked = false;
    
    public static function createFromTemplate(User $student, ProfileTemplate $template)
    {
        $competences = [];
        
        foreach ($template->getCompetences() as $competence) {
            $competences[] = Competence::createFromTemplate($competence);
        }
        
        return new static($student, $competences, $template->getExtraPoints());
    }
    
    public function __construct(User $student, array $competences, $extraPoints)
    {
        $this->competences = new ArrayCollection($competences);
        $this->student = $student;

        $this->totalPoints = $this->getRequiredPoints() + $extraPoints;

    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @Serializer\VirtualProperty()
     * 
     * @return integer
     */
    public function getAvailablePoints()
    {
        return $this->totalPoints - $this->getAssignedPoints();
    }

    /**
     * @return integer
     */
    public function getAssignedPoints()
    {
        $assignedPoints = 0;

        foreach ($this->getCompetences() as $competence) {
            $assignedPoints += $competence->getAssignedPoints();
        }

        return $assignedPoints;
    }

    /**
     * @return integer
     */
    public function getTotalPoints()
    {
        return $this->totalPoints;
    }

    /**
     * @return integer
     */
    private function getRequiredPoints()
    {
        $requiredPoints = 0;

        foreach ($this->getCompetences() as $competence) {
            $requiredPoints += $competence->getRequiredPoints();
        }

        return $requiredPoints;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     * @return User
     */
    public function getStudent()
    {
        return $this->student;
    }

    public function setStudent(User $student)
    {
        if (null !== $this->student) {
            throw new \LogicException('Not allowed to override user once set.');
        }
        
        $this->student = $student;

        return $this;
    }

    /**
     * @return User
     */
    public function getCoach()
    {
        return $this->coach;
    }
    
    public function setCoach(User $coach)
    {
        $this->coach = $coach;
        
        return $this;
    }

    /**
     * @return boolean
     */
    public function isLocked()
    {
        return $this->locked;
    }
    
    public function lock()
    {
        $this->locked = true;
        
        return $this;
    }
    
    public function unlock()
    {
        $this->locked = false;

        return $this;
    }
}
