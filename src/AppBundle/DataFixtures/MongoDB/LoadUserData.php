<?php

namespace Sparse\AppBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Sparse\AppBundle\Document\User;

class LoadUserData extends AbstractFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $coach   = User::create('coach');
        $student = User::create('student');

        $manager->persist($coach);
        $manager->persist($student);

        $manager->flush();
        
        $this->addReference('user:coach', $coach);
        $this->addReference('user:student', $student);
    }
}
