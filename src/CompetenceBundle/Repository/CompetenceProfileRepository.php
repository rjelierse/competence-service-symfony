<?php

namespace Sparse\CompetenceBundle\Repository;

use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Sparse\AppBundle\Document\User;
use Sparse\CompetenceBundle\Document\Profile;

/**
 * Repository for Profile documents.
 *
 * @author Raymond Jelierse <raymond@shareworks.nl>
 */
class CompetenceProfileRepository extends DocumentRepository 
{
    /**
     * Find all competence profiles for a user.
     * 
     * @param User $user
     *
     * @return Cursor|Profile[]
     */
    public function findForUser(User $user)
    {
        return $this->createQueryBuilder()
            ->field('user')->references($user)
            ->getQuery()
            ->execute();
    }
    
    /**
     * Find all competence profiles for a coach.
     * 
     * @param User $user
     *
     * @return Cursor|Profile[]
     */
    public function findForCoach(User $user)
    {
        return $this->createQueryBuilder()
            ->field('coach')->references($user)
            ->getQuery()
            ->execute();
    }
}
