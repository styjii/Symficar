<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonneFixtures extends Fixture
{
    public const PERSONNE_1_REFERENCE = 'personne-1';
    public const PERSONNE_2_REFERENCE = 'personne-2';

    public function load(ObjectManager $manager): void
    {
        $personne1 = new Personne();
        $personne1->setNom('Rakoto')
            ->setPrenom('Jean')
            ->setTelephone('0341234567')
            ->setEmail('jean.rakoto@example.com')
            ->setNumeroPermis('PERM123456');
        $manager->persist($personne1);
        $this->addReference(self::PERSONNE_1_REFERENCE, $personne1);

        $personne2 = new Personne();
        $personne2->setNom('Andria')
            ->setPrenom('Fara')
            ->setTelephone('0329876543')
            ->setEmail('fara.andria@example.com')
            ->setNumeroPermis('PERM654321');
        $manager->persist($personne2);
        $this->addReference(self::PERSONNE_2_REFERENCE, $personne2);

        $manager->flush();
    }
}
