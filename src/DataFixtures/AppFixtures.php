<?php

// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\{SkillCategory, Skill, Employee, EmployeeSkill};
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Backend' => ['PHP', 'Kotlin', 'Python', 'Java', 'Go'],
            'Frontend' => ['JavaScript', 'React', 'Vue', 'Angular'],
            'Data' => ['SQL', 'Pandas', 'Spark', 'MySQL', 'PostgreSQL'],
            'Cloud' => ['AWS', 'Azure', 'Docker', 'Kubernetes', 'Terraform'],
            'BI' => ['PowerBI', 'Tableau', 'Qlik']
        ];

        // Store skills by name for later reference
        $skillsMap = [];

        foreach ($categories as $catName => $skills) {
            $category = new SkillCategory();
            $category->setName($catName);
            $manager->persist($category);

            foreach ($skills as $skillName) {
                $skill = new Skill();
                $skill->setName($skillName)
                    ->setSkillCategory($category);
                $manager->persist($skill);

                // Store reference to this skill
                $skillsMap[$skillName] = $skill;
            }
        }

        $employees = [
            'Alice Doe' => ['PHP' => 5, 'AWS' => 3, 'Docker' => 4],
            'Bob Doe' => ['React' => 4, 'Java' => 2, 'Angular' => 3],
            'John Doe' => ['SQL' => 4, 'PowerBI' => 5, 'Tableau' => 3],
            'Jane Doe' => ['Python' => 3, 'Kubernetes' => 4, 'Terraform' => 2]
        ];

        foreach ($employees as $fullName => $skills) {
            $nameParts = explode(' ', $fullName);
            $employee = new Employee();
            $employee->setName($nameParts[0])
                    ->setLastname($nameParts[1]);
            $manager->persist($employee);

            foreach ($skills as $skillName => $score) {
                // Use the stored skill reference instead of querying
                if (isset($skillsMap[$skillName])) {
                    $skill = $skillsMap[$skillName];

                    $empSkill = new EmployeeSkill();
                    $empSkill->setEmployee($employee)
                        ->setSkill($skill)
                        ->setScore($score);
                    $manager->persist($empSkill);
                }
            }
        }

        $manager->flush();
    }
}