<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $lastname = null;

    /**
     * @var Collection<int, EmployeeSkill>
     */
    #[ORM\OneToMany(targetEntity: EmployeeSkill::class, mappedBy: 'employee')]
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

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
            $employeeSkill->setEmployee($this);
        }

        return $this;
    }

    public function removeEmployeeSkill(EmployeeSkill $employeeSkill): static
    {
        if ($this->employeeSkills->removeElement($employeeSkill)) {
            // set the owning side to null (unless already changed)
            if ($employeeSkill->getEmployee() === $this) {
                $employeeSkill->setEmployee(null);
            }
        }

        return $this;
    }
}
