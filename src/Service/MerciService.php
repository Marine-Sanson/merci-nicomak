<?php

namespace App\Service;

use DateTimeZone;
use App\Entity\User;
use App\Entity\Merci;
use DateTimeImmutable;
use App\Repository\MerciRepository;

class MerciService
{
    public function __construct(
        private readonly MerciRepository $merciRepository,
    ) {

    }

    public function saveMerci(Merci $merci): void
    {
        $this->merciRepository->save($merci);
    }

    public function findAllMercis(): array
    {
        return $this->merciRepository->findAllOrderedByDate();
    }

    public function findAllMyMercis(User $user): array
    {
        return $this->merciRepository->findAllByAuthor($user);
    }

    public function findOneById(int $id): Merci
    {
        return $this->merciRepository->findOneById($id);
    }
    
    public function deleteMerciIfExist(int $id): bool
    {
        $merci = $this->merciRepository->findOneById($id);
        if ($merci === null) {
            return false;
        }

        $this->merciRepository->deleteMerci($merci);
        return true;
    }

}
