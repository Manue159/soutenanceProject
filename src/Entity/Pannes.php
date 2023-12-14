<?php

namespace App\Entity;

use App\Repository\PannesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PannesRepository::class)
 */
class Pannes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_delete;

    /**
     * @ORM\OneToMany(targetEntity=EmployesPannes::class, mappedBy="pannes")
     */
    private $employesPannes;

    /**
     * @ORM\ManyToOne(targetEntity=Materiels::class, inversedBy="pannes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $materiel;

    public function __construct()
    {
        $this->employesPannes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getIsDelete(): ?bool
    {
        return $this->is_delete;
    }

    public function setIsDelete(bool $is_delete): self
    {
        $this->is_delete = $is_delete;

        return $this;
    }

    /**
     * @return Collection<int, EmployesPannes>
     */
    public function getEmployesPannes(): Collection
    {
        return $this->employesPannes;
    }

    public function addEmployesPanne(EmployesPannes $employesPanne): self
    {
        if (!$this->employesPannes->contains($employesPanne)) {
            $this->employesPannes[] = $employesPanne;
            $employesPanne->setPannes($this);
        }

        return $this;
    }

    public function removeEmployesPanne(EmployesPannes $employesPanne): self
    {
        if ($this->employesPannes->removeElement($employesPanne)) {
            // set the owning side to null (unless already changed)
            if ($employesPanne->getPannes() === $this) {
                $employesPanne->setPannes(null);
            }
        }

        return $this;
    }

    public function getMateriel(): ?Materiels
    {
        return $this->materiel;
    }

    public function setMateriel(?Materiels $materiel): self
    {
        $this->materiel = $materiel;

        return $this;
    }
}
