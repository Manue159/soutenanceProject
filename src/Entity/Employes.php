<?php

namespace App\Entity;

use App\Repository\EmployesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployesRepository::class)
 */
class Employes
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $paswword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pole;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_delete;

    /**
     * @ORM\OneToMany(targetEntity=EmployesPannes::class, mappedBy="employes")
     */
    private $employesPannes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_admin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_technicien;

    public function __construct()
    {
        $this->employesPannes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPaswword(): ?string
    {
        return $this->paswword;
    }

    public function setPaswword(string $paswword): self
    {
        $this->paswword = $paswword;

        return $this;
    }

    public function getPole(): ?string
    {
        return $this->pole;
    }

    public function setPole(string $pole): self
    {
        $this->pole = $pole;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

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
            $employesPanne->setEmployes($this);
        }

        return $this;
    }

    public function removeEmployesPanne(EmployesPannes $employesPanne): self
    {
        if ($this->employesPannes->removeElement($employesPanne)) {
            // set the owning side to null (unless already changed)
            if ($employesPanne->getEmployes() === $this) {
                $employesPanne->setEmployes(null);
            }
        }

        return $this;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->is_admin;
    }

    public function setIsAdmin(bool $is_admin): self
    {
        $this->is_admin = $is_admin;

        return $this;
    }

    public function getIsTechnicien(): ?bool
    {
        return $this->is_technicien;
    }

    public function setIsTechnicien(bool $is_technicien): self
    {
        $this->is_technicien = $is_technicien;

        return $this;
    }
}
