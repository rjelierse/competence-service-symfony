<?php

namespace Sparse\AppBundle\Security\Core\Authorization\Voter;

use Sparse\AppBundle\Document\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * Access voter for the User object.
 *
 * @author Raymond Jelierse <raymond@shareworks.nl>
 */
class UserVoter extends AbstractAttributeVoter 
{
    /**
     * {@inheritdoc}
     *
     * @param User $user
     */
    protected function voteAttribute(TokenInterface $token, $user, $attribute)
    {
        switch ($attribute) {
            case 'VIEW':
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
