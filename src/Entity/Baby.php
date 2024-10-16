<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Repository\BabyRepository;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Table(name: 'babies')]
#[ORM\Entity(repositoryClass: BabyRepository::class)]
#[UniqueEntity('table_link')]
#[ApiResource(
        operations: [
            new Get(normalizationContext: ['groups' => 'baby:item']),
            new GetCollection(normalizationContext: ['groups' => 'baby:list']),
            new Patch(),
        ],
    forceEager: false,
    paginationEnabled: false,
)]
#[ApiFilter(BooleanFilter::class, properties: ['isActive'])]
class Baby
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['baby:list', 'baby:item', 'table:babies', 'table:item'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['baby:list', 'baby:item', 'table:babies', 'table:item'])]
    private ?bool $isActive = null;

    #[ORM\Column]
    #[Groups(['baby:list', 'baby:item', 'table:babies', 'table:item'])]
    private ?string $fullName = null;

    #[ORM\ManyToOne(inversedBy: 'babies')]
    #[Groups(['baby:list', 'baby:item'])]
    private ?Table $table_link = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function __toString(): string
    {
        return $this->fullName;
    }

    public function getTableLink(): ?Table
    {
        return $this->table_link;
    }

    public function setTableLink(?Table $table_link): static
    {
        $this->table_link = $table_link;

        return $this;
    }
}