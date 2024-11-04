<?php

declare(strict_types=1);

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document(collection: 'restaurants')]
class Restaurant
{
    #[ODM\Id]
    public ?string $id = null;

    #[ODM\Field]
    public string $name;

    #[ODM\Field]
    public string $borough;

    #[ODM\Field]
    public string $cuisine;


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
     public function getBorough(): ?string
    {
        return $this->borough;
    }

    public function setBorough(string $borough): static
    {
        $this->borough = $borough;

        return $this;
    }

    public function getCuisine(): ?string
    {
        return $this->cuisine;
    }

    public function setCuisine(string $cuisine): static
    {
        $this->cuisine = $cuisine;

        return $this;
    }
}
