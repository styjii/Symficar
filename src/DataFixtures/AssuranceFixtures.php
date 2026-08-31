<?php

namespace App\DataFixtures;

use App\Entity\Assurance;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AssuranceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var Voiture $voiture1 */
        $voiture1 = $this->getReference(VoitureFixtures::VOITURE_1_REFERENCE, Voiture::class);
        /** @var Voiture $voiture2 */
        $voiture2 = $this->getReference(VoitureFixtures::VOITURE_2_REFERENCE, Voiture::class);
        /** @var Voiture $voiture3 */
        $voiture3 = $this->getReference(VoitureFixtures::VOITURE_3_REFERENCE, Voiture::class);

        // Assurance active, valide longtemps encore
        $assurance1 = new Assurance();
        $assurance1->setCompagnie('NY HAVANA')
            ->setNumeroContrat('CTR-0001')
            ->setDateDebut(new \DateTime('2026-01-01'))
            ->setDateFin(new \DateTime('2027-01-01'))
            ->setMontant(150000)
            ->setActive(true)
            ->setVoiture($voiture1);
        $manager->persist($assurance1);

        // Ancien contrat expiré, remplacé (historique)
        $assurance2 = new Assurance();
        $assurance2->setCompagnie('ARO')
            ->setNumeroContrat('CTR-0002')
            ->setDateDebut(new \DateTime('2024-06-01'))
            ->setDateFin(new \DateTime('2025-06-01'))
            ->setMontant(120000)
            ->setActive(false)
            ->setVoiture($voiture1);
        $manager->persist($assurance2);

        // Assurance active, mais qui expire bientôt (pour tester l'alerte)
        $assurance3 = new Assurance();
        $assurance3->setCompagnie('MAMA')
            ->setNumeroContrat('CTR-0003')
            ->setDateDebut(new \DateTime('2025-09-15'))
            ->setDateFin((new \DateTime())->modify('+15 days'))
            ->setMontant(95000)
            ->setActive(true)
            ->setVoiture($voiture2);
        $manager->persist($assurance3);

        // Assurance active, longue durée
        $assurance4 = new Assurance();
        $assurance4->setCompagnie('NY HAVANA')
            ->setNumeroContrat('CTR-0004')
            ->setDateDebut(new \DateTime('2026-03-01'))
            ->setDateFin(new \DateTime('2027-03-01'))
            ->setMontant(180000)
            ->setActive(true)
            ->setVoiture($voiture3);
        $manager->persist($assurance4);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [VoitureFixtures::class];
    }
}
