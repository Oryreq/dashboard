<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Repository\TableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Table(name: 'tables')]
#[ORM\Entity(repositoryClass: TableRepository::class)]
#[UniqueEntity('tableNumber')]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'table:item']),
        new GetCollection(normalizationContext: ['groups' => 'table:list']),
        new Get(uriTemplate: '/tables/{id}/babies', normalizationContext: ['groups' => 'table:babies']),
        new Patch(),
    ],
    forceEager: false,
    paginationEnabled: false,
)]
class Table
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['table:list', 'table:item', 'baby:list', 'baby:item'])]
    private ?int $id = null;

    #[ORM\Column(name: 'table_number')]
    #[Groups(['table:list', 'table:item', 'baby:list', 'baby:item'])]
    private int $tableNumber;

    #[ORM\Column(nullable: true)]
    #[Groups(['table:list', 'table:item', 'baby:list', 'baby:item'])]
    private ?string $description;

    #[ORM\Column]
    #[Groups(['table:list', 'table:item', 'baby:list', 'baby:item'])]
    private ?int $babiesCount = 0;

    /**
     * @var Collection<int, Baby>
     */
    #[ORM\OneToMany(targetEntity: Baby::class, mappedBy: 'table_link')]
    #[Groups(['table:list', 'table:item', 'table:babies', 'baby:list', 'baby:item'])]
    private Collection $babies;

    public function __construct()
    {
        $this->babies = new ArrayCollection();
    }


    #[Groups(['table:list', 'table:item', 'baby:list', 'baby:item'])]
    public function getBabiesCount(): int
    {
        return $this->babies->count();
    }

    #[Groups(['table:list', 'table:item', 'baby:list', 'baby:item'])]
    public function getCurrentBabiesCount(): int
    {
        return $this->babies->filter(function($baby) {
            return $baby->getIsActive();
        })->count();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTableNumber(): ?int
    {
        return $this->tableNumber;
    }

    public function setTableNumber(?int $tableNumber): void
    {
        $this->tableNumber = $tableNumber;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setBabiesCount(?int $babiesCount): void
    {
        $this->babiesCount = $babiesCount;
    }


    public function __toString(): string
    {
        return $this->tableNumber;
    }

    /**
     * @return Collection<int, Baby>
     */
    public function getBabies(): Collection
    {
        return $this->babies;
    }

    public function addBaby(Baby $baby): static
    {
        if (!$this->babies->contains($baby)) {
            $this->babies->add($baby);
            $baby->setTableLink($this);
        }

        return $this;
    }

    public function removeBaby(Baby $baby): static
    {
        if ($this->babies->removeElement($baby)) {
            // set the owning side to null (unless already changed)
            if ($baby->getTableLink() === $this) {
                $baby->setTableLink(null);
            }
        }

        return $this;
    }
}