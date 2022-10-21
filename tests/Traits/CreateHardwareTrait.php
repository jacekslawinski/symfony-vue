<?php

namespace Tests\Traits;

use App\Entity\Hardware;

trait CreateHardwareTrait
{
    use WithFaker;

    /**
     *
     * @param int $count, default: 1
     * @return array
     */
    protected function createSeveralHardwares(int $count = 1): array
    {
        $systems = [];
        for ($i = 0; $i < $count; $i++) {
            $systems[] = $this->createHardware();
        }
        return $systems;
    }

    /**
     *
     * @return Hardware
     */
    protected function createHardware(): Hardware
    {
        $hardware = new Hardware();
        $hardware->setName($this->faker->text(100))
            ->setSerialNumber($this->faker->text(100))
            ->setProductionMonth($this->faker->date('Y-m'));
        $this->entityManager->persist($hardware);
        $this->entityManager->flush();
        return $hardware;
    }
}
