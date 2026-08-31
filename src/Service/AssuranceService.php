<?php

namespace App\Service;

use App\Entity\Assurance;
use App\Repository\AssuranceRepository;

class AssuranceService
{
    public function __construct(
        private readonly AssuranceRepository $assuranceRepository,
    ) {
    }

    /**
     * Indique si une assurance est expirée à la date actuelle.
     */
    public function estExpiree(Assurance $assurance): bool
    {
        return $assurance->getDateFin() < new \DateTime('now');
    }

    /**
     * Retourne les assurances actives qui expirent dans les $jours prochains jours.
     *
     * @return Assurance[]
     */
    public function assurancesExpirantBientot(int $jours = 30): array
    {
        $limite = (new \DateTime())->modify("+{$jours} days");

        return $this->assuranceRepository->createQueryBuilder('a')
            ->andWhere('a.dateFin <= :limite')
            ->andWhere('a.active = true')
            ->setParameter('limite', $limite)
            ->orderBy('a.dateFin', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne, parmi les assurances actives d'une voiture donnée, celles qui
     * expirent dans les $jours prochains jours.
     *
     * @param iterable<Assurance> $assurances
     *
     * @return Assurance[]
     */
    public function assurancesExpirantBientotPourVoiture(iterable $assurances, int $jours = 30): array
    {
        $limite = (new \DateTime())->modify("+{$jours} days");
        $resultat = [];

        foreach ($assurances as $assurance) {
            if ($assurance->isActive() && $assurance->getDateFin() <= $limite) {
                $resultat[] = $assurance;
            }
        }

        return $resultat;
    }
}
