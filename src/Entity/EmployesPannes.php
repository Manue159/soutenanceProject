<?php

namespace App\Entity;

use App\Repository\EmployesPannesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployesPannesRepository::class)
 */
class EmployesPannes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_delete;

    /**
     * @ORM\ManyToOne(targetEntity=Employes::class, inversedBy="employesPannes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $employes;

    /**
     * @ORM\ManyToOne(targetEntity=Pannes::class, inversedBy="employesPannes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pannes;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmployes(): ?Employes
    {
        return $this->employes;
    }

    public function setEmployes(?Employes $employes): self
    {
        $this->employes = $employes;

        return $this;
    }

    public function getPannes(): ?Pannes
    {
        return $this->pannes;
    }

    public function setPannes(?Pannes $pannes): self
    {
        $this->pannes = $pannes;

        return $this;
    }
}
