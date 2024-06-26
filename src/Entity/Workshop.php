<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\WorkshopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(),
        new Put(),
        new Patch(),
        new Delete(),
        new GetCollection(),
        new Post(),
    ],
    normalizationContext: ['groups' => ['workshop:read']],
    denormalizationContext: ['groups' => ['workshop:write']],
    order: ['date' => 'DESC'],
)]
#[ORM\Entity(repositoryClass: WorkshopRepository::class)]
#[ApiFilter(filterClass: SearchFilter::class, properties: ['center' => 'exact'])]
class Workshop
{
    use TimestampableEntity;

    #[Groups(['read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $nbParticipants = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $globalReport = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $topicPrecision = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'workshops')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[Groups(['workshop:write'])]
    #[ORM\ManyToOne(targetEntity: Center::class, inversedBy: 'workshops')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Center $center = null;

    /** @var Collection<int, ParticipantKind> $participantKinds */
    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\ManyToMany(targetEntity: ParticipantKind::class, inversedBy: 'workshops')]
    private Collection $participantKinds;

    /** @var Collection<int, Topic> $topics */
    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\ManyToMany(targetEntity: Topic::class, mappedBy: 'workshops')]
    private Collection $topics;

    /** @var Collection<int, AgeBreakpoint> $ageBreakpoints */
    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\ManyToMany(targetEntity: AgeBreakpoint::class, inversedBy: 'workshops')]
    private Collection $ageBreakpoints;

    /** @var Collection<int, EquipmentSupplier> $equipmentSuppliers */
    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\ManyToMany(targetEntity: EquipmentSupplier::class, inversedBy: 'workshops')]
    private Collection $equipmentSuppliers;

    /** @var Collection<int, UsedEquipment> $usedEquipments */
    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\ManyToMany(targetEntity: UsedEquipment::class, inversedBy: 'workshops')]
    private Collection $usedEquipments;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => 0])]
    private ?bool $usedVault = false;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $nbBeneficiariesAccounts = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $nbStoredDocs = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $nbCreatedEvents = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $nbCreatedContacts = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $nbCreatedNotes = null;

    /** @var Collection<int, Skill> */
    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\ManyToMany(targetEntity: Skill::class, inversedBy: 'workshops')]
    private Collection $skills;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $attendees = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $improvementAxis = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\ManyToOne(targetEntity: Duration::class, inversedBy: 'workshops')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Duration $duration = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $maleCount = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $femaleCount = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $noGenderCount = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $place = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $nbNewParticipants = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $updateProposal = null;

    #[Groups(['workshop:read', 'workshop:write'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $addProposal = null;

    public function __construct()
    {
        $this->participantKinds = new ArrayCollection();
        $this->topics = new ArrayCollection();
        $this->ageBreakpoints = new ArrayCollection();
        $this->equipmentSuppliers = new ArrayCollection();
        $this->usedEquipments = new ArrayCollection();
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

    /** @return Collection<int, ParticipantKind> */
    public function getParticipantKinds(): Collection
    {
        return $this->participantKinds;
    }

    public function addParticipantKind(ParticipantKind $participantKind): self
    {
        if (!$this->participantKinds->contains($participantKind)) {
            $this->participantKinds->add($participantKind);
        }

        return $this;
    }

    public function removeParticipantKind(ParticipantKind $participantKind): self
    {
        $this->participantKinds->removeElement($participantKind);

        return $this;
    }

    /** @return Collection<int, Topic> */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics->add($topic);
            $topic->addWorkshop($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topics->removeElement($topic)) {
            $topic->removeWorkshop($this);
        }

        return $this;
    }

    /** @return Collection<int, AgeBreakpoint> */
    public function getAgeBreakpoints(): Collection
    {
        return $this->ageBreakpoints;
    }

    public function addAgeBreakpoint(AgeBreakpoint $ageBreakpoint): self
    {
        if (!$this->ageBreakpoints->contains($ageBreakpoint)) {
            $this->ageBreakpoints->add($ageBreakpoint);
        }

        return $this;
    }

    public function removeAgeBreakpoint(AgeBreakpoint $ageBreakpoint): self
    {
        $this->ageBreakpoints->removeElement($ageBreakpoint);

        return $this;
    }

    /** @return Collection<int, EquipmentSupplier> */
    public function getEquipmentSuppliers(): Collection
    {
        return $this->equipmentSuppliers;
    }

    public function addEquipmentSupplier(EquipmentSupplier $equipmentSupplier): self
    {
        if (!$this->equipmentSuppliers->contains($equipmentSupplier)) {
            $this->equipmentSuppliers->add($equipmentSupplier);
        }

        return $this;
    }

    public function removeEquipmentSupplier(EquipmentSupplier $equipmentSupplier): self
    {
        $this->equipmentSuppliers->removeElement($equipmentSupplier);

        return $this;
    }

    /** @return Collection<int, UsedEquipment> */
    public function getUsedEquipments(): Collection
    {
        return $this->usedEquipments;
    }

    public function addUsedEquipment(UsedEquipment $usedEquipment): self
    {
        if (!$this->usedEquipments->contains($usedEquipment)) {
            $this->usedEquipments->add($usedEquipment);
        }

        return $this;
    }

    public function removeUsedEquipment(UsedEquipment $usedEquipment): self
    {
        $this->usedEquipments->removeElement($usedEquipment);

        return $this;
    }

    public function hasUsedVault(): ?bool
    {
        return $this->usedVault;
    }

    public function setUsedVault(bool $usedVault): self
    {
        $this->usedVault = $usedVault;

        return $this;
    }

    public function getNbBeneficiariesAccounts(): ?int
    {
        return $this->nbBeneficiariesAccounts;
    }

    public function setNbBeneficiariesAccounts(int $nbBeneficiariesAccounts): self
    {
        $this->nbBeneficiariesAccounts = $nbBeneficiariesAccounts;

        return $this;
    }

    public function getNbStoredDocs(): ?int
    {
        return $this->nbStoredDocs;
    }

    public function setNbStoredDocs(int $nbStoredDocs): self
    {
        $this->nbStoredDocs = $nbStoredDocs;

        return $this;
    }

    public function getNbCreatedEvents(): ?int
    {
        return $this->nbCreatedEvents;
    }

    public function setNbCreatedEvents(int $nbCreatedEvents): self
    {
        $this->nbCreatedEvents = $nbCreatedEvents;

        return $this;
    }

    public function getNbCreatedContacts(): ?int
    {
        return $this->nbCreatedContacts;
    }

    public function setNbCreatedContacts(int $nbCreatedContacts): self
    {
        $this->nbCreatedContacts = $nbCreatedContacts;

        return $this;
    }

    public function getNbCreatedNotes(): ?int
    {
        return $this->nbCreatedNotes;
    }

    public function setNbCreatedNotes(int $nbCreatedNotes): self
    {
        $this->nbCreatedNotes = $nbCreatedNotes;

        return $this;
    }

    /** @return Collection<int, Skill> */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        $this->skills->removeElement($skill);

        return $this;
    }

    public function getAttendees(): ?string
    {
        return $this->attendees;
    }

    public function setAttendees(string $attendees): self
    {
        $this->attendees = $attendees;

        return $this;
    }

    public function getImprovementAxis(): ?string
    {
        return $this->improvementAxis;
    }

    public function setImprovementAxis(?string $improvementAxis): self
    {
        $this->improvementAxis = $improvementAxis;

        return $this;
    }

    public function getDuration(): ?Duration
    {
        return $this->duration;
    }

    public function setDuration(?Duration $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getMaleCount(): ?int
    {
        return $this->maleCount;
    }

    public function setMaleCount(?int $maleCount): self
    {
        $this->maleCount = $maleCount;

        return $this;
    }

    public function getFemaleCount(): ?int
    {
        return $this->femaleCount;
    }

    public function setFemaleCount(?int $femaleCount): self
    {
        $this->femaleCount = $femaleCount;

        return $this;
    }

    public function getNoGenderCount(): ?int
    {
        return $this->noGenderCount;
    }

    public function setNoGenderCount(?int $noGenderCount): self
    {
        $this->noGenderCount = $noGenderCount;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getNbNewParticipants(): ?int
    {
        return $this->nbNewParticipants;
    }

    public function setNbNewParticipants(?int $nbNewParticipants): self
    {
        $this->nbNewParticipants = $nbNewParticipants;

        return $this;
    }

    public function getUpdateProposal(): ?string
    {
        return $this->updateProposal;
    }

    public function setUpdateProposal(?string $updateProposal): static
    {
        $this->updateProposal = $updateProposal;

        return $this;
    }

    public function getAddProposal(): ?string
    {
        return $this->addProposal;
    }

    public function setAddProposal(?string $addProposal): static
    {
        $this->addProposal = $addProposal;

        return $this;
    }
}
