<?php

namespace Tests\Traits;

use App\Entity\System;

trait CreateSystemTrait
{
    use WithFaker;

    /**
     *
     * @param int $count, default: 1
     * @return array
     */
    private function createSeveralSystems(int $count = 1): array
    {
        $systems = [];
        for ($i = 0; $i < $count; $i++) {
            $systems[] = $this->createSystem();
        }
        return $systems;
    }

    /**
     *
     * @return System
     */
    private function createSystem(): System
    {
        $system = new System();
        $system->setName($this->faker->text(100));
        $this->entityManager->persist($system);
        $this->entityManager->flush();
        return $system;
    }
}
