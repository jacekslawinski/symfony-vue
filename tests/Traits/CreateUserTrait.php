<?php

namespace Tests\Traits;

use App\Entity\User;

trait CreateUserTrait
{
    use WithFaker;

    /**
     *
     * @param int $count, default: 1
     * @return array
     */
    protected function createSeveralUsers(int $count = 1): array
    {
        $users = [];
        for ($i = 0; $i < $count; $i++) {
            $users[] = $this->createUser();
        }
        return $users;
    }

    /**
     *
     * @return User
     */
    protected function createUser(): User
    {
        $user = new User();
        $user->setLastname($this->faker->lastName())
            ->setFirstname($this->faker->firstName())
            ->setEmail($this->faker->email());
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }
}
