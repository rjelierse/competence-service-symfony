<?php

namespace Sparse\CompetenceBundle\Validator\Constraint;

use Sparse\CompetenceBundle\Document\Profile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validator for the "TotalPoints" constraint.
 *
 * @author Raymond Jelierse <raymond@shareworks.nl>
 */
class TotalPointsValidator extends ConstraintValidator 
{
    /**
     * {@inheritdoc}
     * 
     * @param TotalPoints $constraint
     */
    public function validate($profile, Constraint $constraint)
    {
        if (!$profile instanceof Profile) {
            throw new \InvalidArgumentException('This validator is meant to validate instances of Profile.');
        }
        
        if ($profile->getAssignedPoints() !== $profile->getTotalPoints()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%sum%', $profile->getAssignedPoints())
                ->setParameter('%total%', $profile->getTotalPoints())
                ->addViolation();
        }
    }
}
