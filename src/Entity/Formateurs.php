<?php

namespace App\Entity;

use App\Repository\FormateursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormateursRepository::class)
 */
class Formateurs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nomFormateur;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $prenomFormateur;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $loginFormateur;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $mdpFormateur;

    /**
     * @ORM\OneToMany(targetEntity=Formations::class, mappedBy="idFormateur")
     */
    private $formations;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFormateur(): ?string
    {
        return $this->nomFormateur;
    }

    public function setNomFormateur(string $nomFormateur): self
    {
        $this->nomFormateur = $nomFormateur;

        return $this;
    }

    public function getPrenomFormateur(): ?string
    {
        return $this->prenomFormateur;
    }

    public function setPrenomFormateur(string $prenomFormateur): self
    {
        $this->prenomFormateur = $prenomFormateur;

        return $this;
    }

    public function getLoginFormateur(): ?string
    {
        return $this->loginFormateur;
    }

    public function setLoginFormateur(string $loginFormateur): self
    {
        $this->loginFormateur = $loginFormateur;

        return $this;
    }

    public function getMdpFormateur(): ?string
    {
        return $this->mdpFormateur;
    }

    public function setMdpFormateur(string $mdpFormateur): self
    {
        $this->mdpFormateur = $mdpFormateur;

        return $this;
    }
    public function toString(){
    return $this->nomFormateur.' '.$this->prenomFormateur;
}

    /**
     * @return Collection|Formations[]
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formations $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setIdFormateur($this);
        }

        return $this;
    }

    public function removeFormation(Formations $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getIdFormateur() === $this) {
                $formation->setIdFormateur(null);
            }
        }

        return $this;
    }
}
