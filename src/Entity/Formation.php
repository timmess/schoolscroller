<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=School::class, inversedBy="formations")
     * @ORM\JoinTable(name="school_formation",
     *      joinColumns={
     *          @ORM\JoinColumn(name="formation_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="school_id", referencedColumnName="id")
     *     }
     * )
     */
    private $school;

    /**
     * @ORM\ManyToMany(targetEntity=Modules::class, inversedBy="formation")
     * @ORM\JoinTable(name="formation_modules",
     *      joinColumns={
     *          @ORM\JoinColumn(name="formation_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="modules_id", referencedColumnName="id")
     *     }
     * ))
     */
    private $modules;

    public function __construct()
    {
        $this->school = new ArrayCollection();
        $this->modules = new ArrayCollection();
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

    /**
     * @return Collection|School[]
     */
    public function getSchool(): Collection
    {
        return $this->school;
    }

    public function addSchool(School $school): self
    {
        if (!$this->school->contains($school)) {
            $this->school[] = $school;
        }

        return $this;
    }

    public function removeSchool(School $school): self
    {
        $this->school->removeElement($school);

        return $this;
    }

    /**
     * @return Collection|Modules[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Modules $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
            $module->addFormation($this);
        }

        return $this;
    }

    public function removeModule(Modules $module): self
    {
        if ($this->modules->removeElement($module)) {
            $module->removeFormation($this);
        }

        return $this;
    }
}
