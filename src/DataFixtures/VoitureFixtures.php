<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VoitureFixtures extends Fixture implements DependentFixtureInterface
{
    public const VOITURE_1_REFERENCE = 'voiture-1';
    public const VOITURE_2_REFERENCE = 'voiture-2';
    public const VOITURE_3_REFERENCE = 'voiture-3';

    public function load(ObjectManager $manager): void
    {
        /** @var Personne $personne1 */
        $personne1 = $this->getReference(PersonneFixtures::PERSONNE_1_REFERENCE, Personne::class);
        /** @var Personne $personne2 */
        $personne2 = $this->getReference(PersonneFixtures::PERSONNE_2_REFERENCE, Personne::class);

        $voiture1 = new Voiture();
        $voiture1->setMarque('Toyota')
            ->setModele('Corolla')
            ->setImmatriculation('1234 TAA')
            ->setAnnee(2020)
            ->setProprietaire($personne1);
        $manager->persist($voiture1);
        $this->addReference(self::VOITURE_1_REFERENCE, $voiture1);

        $voiture2 = new Voiture();
        $voiture2->setMarque('Renault')
            ->setModele('Clio')
            ->setImmatriculation('5678 TBB')
            ->setAnnee(2018)
            ->setProprietaire($personne1);
        $manager->persist($voiture2);
        $this->addReference(self::VOITURE_2_REFERENCE, $voiture2);

        $voiture3 = new Voiture();
        $voiture3->setMarque('Peugeot')
            ->setModele('208')
            ->setImmatriculation('9012 TCC')
            ->setAnnee(2022)
            ->setProprietaire($personne2);
        $manager->persist($voiture3);
        $this->addReference(self::VOITURE_3_REFERENCE, $voiture3);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [PersonneFixtures::class];
    }
}
