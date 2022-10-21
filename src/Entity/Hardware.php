<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\SoftDeletableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\HardwareRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HardwareRepository::class)]
#[ORM\Table(name: 'hardwares')]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: false)]
class Hardware
{
    use SoftDeletableTrait;
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user', 'hardware'])]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: false)]
    #[Groups(['user', 'hardware'])]
    #[Assert\Type('string')]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 100)]
    private string $name;

    #[ORM\Column(length: 100, nullable: false)]
    #[Groups(['hardware'])]
    #[Assert\Type('string')]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 100)]
    private string $serialNumber;

    #[ORM\Column(length: 7, nullable: false)]
    #[Groups(['hardware'])]
    #[Assert\Type('string')]
    #[Assert\NotBlank()]
    #[Assert\Length(exactly: 7)]
    private string $productionMonth;

    #[ORM\Column(name: 'system_id', nullable: true)]
    #[Groups(['hardware'])]
    private ?int $systemId = null;

    #[ORM\OneToOne(targetEntity: 'UserHardware', mappedBy: 'hardware', cascade:['persist'])]
    #[Groups(['hardware'])]
    private ?UserHardware $userHardware = null;

    /**
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getSerialNumber(): string
    {
        return $this->serialNumber;
    }

    /**
     *
     * @param string $serialNumber
     * @return self
     */
    public function setSerialNumber(string $serialNumber): self
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getProductionMonth(): string
    {
        return $this->productionMonth;
    }

    /**
     *
     * @param string $productionMonth
     * @return self
     */
    public function setProductionMonth(string $productionMonth): self
    {
        $this->productionMonth = $productionMonth;

        return $this;
    }

    /**
     *
     * @return int|null
     */
    public function getSystemId(): ?int
    {
        return $this->systemId;
    }

    /**
     *
     * @param int|null $systemId
     * @return self
     */
    public function setSystemId(?int $systemId): self
    {
        $this->systemId = $systemId;

        return $this;
    }

    /**
     *
     * @return UserHardware|null
     */
    public function getUserHardware(): ?UserHardware
    {
        return $this->userHardware;
    }

    /**
     *
     * @param UserHardware|null $userHardware
     * @return self
     */
    public function setUserHardware(?UserHardware $userHardware): self
    {
        $this->userHardware = $userHardware;

        return $this;
    }
}
