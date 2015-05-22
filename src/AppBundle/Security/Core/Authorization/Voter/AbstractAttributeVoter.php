<?php

namespace Sparse\AppBundle\Security\Core\Authorization\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * Base class for attribute voters.
 *
 * @author Raymond Jelierse <raymond@shareworks.nl>
 */
abstract class AbstractAttributeVoter implements VoterInterface
{
    private $attributes;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * {@inheritdoc}
     */
    final public function supportsAttribute($attribute)
    {
        return in_array($attribute, $this->attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $votes = VoterInterface::ACCESS_ABSTAIN;
        foreach ($attributes as $attribute) {
            $votes += $this->voteAttribute($token, $object, $attribute);
        }

        if ($votes > VoterInterface::ACCESS_ABSTAIN) {
            return VoterInterface::ACCESS_GRANTED;
        } elseif ($votes < VoterInterface::ACCESS_ABSTAIN) {
            return VoterInterface::ACCESS_DENIED;
        } else {
            return VoterInterface::ACCESS_ABSTAIN;
        }
    }

    /**
     * Vote on a specific attribute.
     * 
     * @param TokenInterface $token
     * @param mixed          $object
     * @param string         $attribute
     *
     * @return integer
     */
    abstract protected function voteAttribute(TokenInterface $token, $object, $attribute);
}
