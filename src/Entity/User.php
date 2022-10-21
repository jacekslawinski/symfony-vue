<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\SoftDeletableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: false)]
class User
{
    use SoftDeletableTrait;
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user', 'hardware'])]
    private int $id;

    #[ORM\Column(length: 50, nullable: false)]
    #[Groups(['user', 'hardware'])]
    #[Assert\Type('string')]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 50)]
    private string $firstname;

    #[ORM\Column(length: 50, nullable: false)]
    #[Groups(['user', 'hardware'])]
    #[Assert\Type('string')]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 50)]
    private string $lastname;

    #[ORM\Column(length: 255, nullable: false, unique: true)]
    #[Groups(['user'])]
    #[Assert\Type('string')]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\Email()]
    #[Assert\Length(max: 255)]
    private string $email;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\OneToMany(targetEntity: UserHardware::class, mappedBy: 'user', cascade:['remove'])]
    #[Groups(['user'])]
    private Collection $userHardwares;

    public function __construct()
    {
        $this->userHardwares = new ArrayCollection();
    }

    /**
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     *
     * @param string $firstname
     * @return self
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     *
     * @param string $lastname
     * @return self
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     *
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     *
     * @param string|null $password
     * @return self
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     *
     * @return Collection
     */
    public function getUserHardwares(): Collection
    {
        return $this->userHardwares;
    }

    /**
     *
     * @param array|UserHardware $userHardwares
     * @return self
     */
    public function setUserHardwares(array|UserHardware $userHardwares): self
    {
        $this->userHardwares = new ArrayCollection(
            is_array($userHardwares) ? $userHardwares : [$userHardwares]
        );

        return $this;
    }
}
