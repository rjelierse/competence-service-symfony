<?php

namespace Sparse\CompetenceBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Sparse\CompetenceBundle\Document\CompetenceTemplate;
use Sparse\CompetenceBundle\Document\ProfileTemplate;

class LoadTemplateData extends AbstractFixture 
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $profile = ProfileTemplate::create()
            ->setName('HKU Master OIV')
            ->setExtraPoints(12);
        
        $profile->getCompetences()->add(CompetenceTemplate::create('Fascination', 12));
        $profile->getCompetences()->add(CompetenceTemplate::create('Impact', 12));
        $profile->getCompetences()->add(CompetenceTemplate::create('Vision', 12));
        $profile->getCompetences()->add(CompetenceTemplate::create('Value', 12));
        
        $manager->persist($profile);
        $manager->flush();
    }
}
