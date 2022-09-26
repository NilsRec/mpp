<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CenterTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(shortName: 'tag')]
#[ORM\Entity(repositoryClass: CenterTagRepository::class)]
class CenterTag implements \Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $name = null;

    /** @var ?Collection<int, Center> */
    #[ORM\ManyToMany(targetEntity: Center::class, inversedBy: 'tags')]
    private ?Collection $centers;

    public function __toString(): string
    {
        return (string) $this->name;
    }

    public function __construct()
    {
        $this->centers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /** @return Collection<int, Center> */
    public function getCenters(): Collection
    {
        return $this->centers;
    }

    public function addCenter(Center $center): self
    {
        if (!$this->centers->contains($center)) {
            $this->centers->add($center);
        }

        return $this;
    }

    public function removeCenter(Center $center): self
    {
        $this->centers->removeElement($center);

        return $this;
    }
}
