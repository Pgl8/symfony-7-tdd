<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'skills')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SkillCategory $skillCategory = null;

    /**
     * @var Collection<int, EmployeeSkill>
     */
    #[ORM\OneToMany(targetEntity: EmployeeSkill::class, mappedBy: 'skill')]
    private Collection $employeeSkills;

    public function __construct()
    {
        $this->employeeSkills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSkillCategory(): ?SkillCategory
    {
        return $this->skillCategory;
    }

    public function setSkillCategory(?SkillCategory $skillCategory): static
    {
        $this->skillCategory = $skillCategory;

        return $this;
    }

    /**
     * @return Collection<int, EmployeeSkill>
     */
    public function getEmployeeSkills(): Collection
    {
        return $this->employeeSkills;
    }

    public function addEmployeeSkill(EmployeeSkill $employeeSkill): static
    {
        if (!$this->employeeSkills->contains($employeeSkill)) {
            $this->employeeSkills->add($employeeSkill);
            $employeeSkill->setSkill($this);
        }

        return $this;
    }

    public function removeEmployeeSkill(EmployeeSkill $employeeSkill): static
    {
        if ($this->employeeSkills->removeElement($employeeSkill)) {
            // set the owning side to null (unless already changed)
            if ($employeeSkill->getSkill() === $this) {
                $employeeSkill->setSkill(null);
            }
        }

        return $this;
    }
}
