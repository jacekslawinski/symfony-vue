<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserHardwareRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserHardwareRepository::class)]
#[ORM\Table(name: 'user_hardwares')]
class UserHardware
{
    #[ORM\ManyToOne(targetEntity: 'User', cascade:['persist'])]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName:'id', nullable: false)]
    #[Groups(['hardware'])]
    private User $user;

    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: 'Hardware', cascade:['persist'])]
    #[ORM\JoinColumn(name: 'hardware_id', referencedColumnName:'id', nullable: false)]
    #[Groups(['user'])]
    private Hardware $hardware;

    /**
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     *
     * @param User $user
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     *
     * @return Hardware|null
     */
    public function getHardware(): ?Hardware
    {
        return $this->hardware;
    }

    /**
     *
     * @param Hardware $hardware
     * @return self
     */
    public function setHardware(Hardware $hardware): self
    {
        $this->hardware = $hardware;

        return $this;
    }
}
