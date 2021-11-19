<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\WorkshopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}}
 * )
 * @ORM\Entity(repositoryClass=WorkshopRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"center": "exact"})
 */
class Workshop
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private ?int $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"read"})
     */
    private ?\DateTimeInterface $date;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private ?int $nbParticipants;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"read"})
     */
    private ?string $globalReport;

    /**
     * @ORM\ManyToOne(targetEntity=Topic::class, inversedBy="workshops")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read"})
     */
    private ?Topic $topic;

    /**
     * @ORM\ManyToOne(targetEntity=ParticipantKind::class, inversedBy="workshops")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read"})
     */
    private ?ParticipantKind $participantKind;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="workshops")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read"})
     */
    private ?Project $project;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, inversedBy="workshops")
     * @Groups({"read"})
     */
    private ?Collection $skills;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"read"})
     */
    private ?string $topicPrecision;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="workshops")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $author;

    /**
     * @ORM\ManyToOne(targetEntity=Center::class, inversedBy="workshops")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Center $center;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNbParticipants(): ?int
    {
        return $this->nbParticipants;
    }

    public function setNbParticipants(int $nbParticipants): self
    {
        $this->nbParticipants = $nbParticipants;

        return $this;
    }

    public function getGlobalReport(): ?string
    {
        return $this->globalReport;
    }

    public function setGlobalReport(?string $globalReport): self
    {
        $this->globalReport = $globalReport;

        return $this;
    }

    public function getTopic(): ?topic
    {
        return $this->topic;
    }

    public function setTopic(?topic $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function getParticipantKind(): ?ParticipantKind
    {
        return $this->participantKind;
    }

    public function setParticipantKind(?ParticipantKind $participantKind): self
    {
        $this->participantKind = $participantKind;

        return $this;
    }

    public function getProject(): ?project
    {
        return $this->project;
    }

    public function setProject(?project $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection|skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
        }

        return $this;
    }

    public function removeSkill(skill $skill): self
    {
        $this->skills->removeElement($skill);

        return $this;
    }

    public function getTopicPrecision(): ?string
    {
        return $this->topicPrecision;
    }

    public function setTopicPrecision(?string $topicPrecision): self
    {
        $this->topicPrecision = $topicPrecision;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCenter(): ?Center
    {
        return $this->center;
    }

    public function setCenter(?Center $center): self
    {
        $this->center = $center;

        return $this;
    }
}