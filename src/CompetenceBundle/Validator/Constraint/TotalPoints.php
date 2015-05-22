<?php

namespace Sparse\CompetenceBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * A constraint for the points total on a competence profile.
 *
 * @author Raymond Jelierse <raymond@shareworks.nl>
 *         
 * @Annotation
 */
class TotalPoints extends Constraint 
{
    public $message = 'The sum of points available and spent (%sum%) does not match the total allowed (%total%).';

    public function getTargets()
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}
