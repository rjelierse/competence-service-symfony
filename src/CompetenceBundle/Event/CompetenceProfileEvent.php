<?php

namespace Sparse\CompetenceBundle\Event;

use Sparse\CompetenceBundle\Document\Profile;
use Symfony\Component\EventDispatcher\Event;

/**
 * Events for the Profile object.
 *
 * @author Raymond Jelierse <raymond@shareworks.nl>
 */
class CompetenceProfileEvent extends Event
{
    /**
     * CRUD actions
     */
    const CREATE = 'competenceProfile.create';
    const READ   = 'competenceProfile.read';
    const UPDATE = 'competenceProfile.update';
    const DELETE = 'competenceProfile.delete';
    
    private $profile;
    
    public static function create(Profile $profile)
    {
        return new static($profile);
    }
    
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function getProfile()
    {
        return $this->profile;
    }
}
