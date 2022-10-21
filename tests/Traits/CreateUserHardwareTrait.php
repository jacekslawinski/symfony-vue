<?php

namespace Tests\Traits;

use App\Entity\Hardware;
use App\Entity\User;
use App\Entity\UserHardware;

trait CreateUserHardwareTrait
{
    /**
     *
     * @return Hardware
     */
    protected function createUserHardware(User $user, Hardware $hardware): UserHardware
    {
        $userHardware = new UserHardware();
        $userHardware->setUser($user)
            ->setHardware($hardware);
        $this->entityManager->persist($userHardware);
        $this->entityManager->flush();
        return $userHardware;
    }
}
