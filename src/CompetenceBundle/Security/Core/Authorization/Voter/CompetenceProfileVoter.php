<?php

namespace Sparse\CompetenceBundle\Security\Core\Authorization\Voter;

use Sparse\AppBundle\Security\Core\Authorization\Voter\AbstractAttributeVoter;
use Sparse\CompetenceBundle\Document\Profile;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * Access voter for the Profile object.
 *
 * @author Raymond Jelierse <raymond@shareworks.nl>
 */
class CompetenceProfileVoter extends AbstractAttributeVoter 
{
    /**
     * {@inheritdoc}
     */
    protected function voteAttribute(TokenInterface $token, $object, $attribute)
    {
        return VoterInterface::ACCESS_GRANTED;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === Profile::class;
    }
}
