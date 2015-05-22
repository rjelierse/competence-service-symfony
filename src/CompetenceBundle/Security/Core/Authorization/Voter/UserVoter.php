<?php

namespace Sparse\CompetenceBundle\Security\Core\Authorization\Voter;

use Sparse\AppBundle\Document\User;
use Sparse\AppBundle\Security\Core\Authorization\Voter\AbstractAttributeVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class UserVoter extends AbstractAttributeVoter 
{
    public function __construct()
    {
        parent::__construct(['CREATE_COMPETENCE_PROFILE', 'VIEW_COMPETENCE_PROFILE']);
    }

    /**
     * {@inheritdoc}
     * 
     * @param User $user
     */
    protected function voteAttribute(TokenInterface $token, $user, $attribute)
    {
        switch ($attribute) {
            case 'VIEW_COMPETENCE_PROFILE':
            case 'CREATE_COMPETENCE_PROFILE':
                return VoterInterface::ACCESS_GRANTED;
            
            default:
                return VoterInterface::ACCESS_ABSTAIN;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === User::class;
    }
}
